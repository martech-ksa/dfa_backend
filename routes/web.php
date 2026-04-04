<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\ClassArmController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ResultEntryController;
use App\Http\Controllers\Admin\ClassSubjectController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AttendanceController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Universal Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', function () {

    $user = request()->user();

    if ($user->hasRole(['Super Admin','Admin'])) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('Teacher')) {
        return redirect()->route('teacher.dashboard');
    }

    if ($user->hasRole('Parent')) {
        return redirect()->route('parent.dashboard');
    }

    if ($user->hasRole('Student')) {
        return redirect()->route('student.dashboard');
    }

    abort(403);

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

        // Users
        Route::get('/users', [UserController::class,'index'])->name('users.index');
        Route::post('/users/{user}/role', [UserController::class,'updateRole'])->name('users.updateRole');

        // Academic Structure
        Route::resource('programs', ProgramController::class);
        Route::resource('levels', LevelController::class);
        Route::resource('classarms', ClassArmController::class);

        // Subjects
        Route::resource('subjects', SubjectController::class);

        // Class Subject Assignment
        Route::prefix('class-subjects')->group(function () {
            Route::get('/', [ClassSubjectController::class,'index'])->name('class-subjects.index');
            Route::post('/store', [ClassSubjectController::class,'store'])->name('class-subjects.store');
        });

        // Students
        Route::resource('students', StudentController::class);

        // Promotions
        Route::prefix('promotions')->group(function () {
            Route::get('/', [PromotionController::class,'index'])->name('promotions.index');
            Route::post('/promote', [PromotionController::class,'promote'])->name('promotions.promote');
        });

        /*
        |--------------------------------------------------------------------------
        | RESULTS MODULE (UPDATED)
        |--------------------------------------------------------------------------
        */

        Route::prefix('results')->group(function () {

            // Main Page
            Route::get('/', [ResultEntryController::class,'index'])
                ->name('results.index');

            // Load Students + Subjects
            Route::post('/load-students', [ResultEntryController::class,'loadStudents'])
                ->name('results.loadStudents');

            // Save Results
            Route::post('/store', [ResultEntryController::class,'store'])
                ->name('results.store');

            // 🔥 NEW: Dynamic Filtering
            Route::get('/get-levels/{program}', [ResultEntryController::class,'getLevels']);
            Route::get('/get-class-arms/{level}', [ResultEntryController::class,'getClassArms']);

            // View Result Sheet
            Route::get('/{student}/{class_arm}', [ResultEntryController::class, 'show'])
                ->name('results.show');

        });

        /*
        |--------------------------------------------------------------------------
        | Attendance
        |--------------------------------------------------------------------------
        */

        Route::prefix('attendance')->group(function () {

            Route::get('/', [AttendanceController::class, 'index'])
                ->name('attendance.index');

            Route::post('/load-students', [AttendanceController::class, 'loadStudents'])
                ->name('attendance.loadStudents');

            Route::post('/store', [AttendanceController::class, 'store'])
                ->name('attendance.store');

        });

});


/*
|--------------------------------------------------------------------------
| TEACHER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:Teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('teacher.dashboard'))->name('dashboard');

        Route::prefix('results')->group(function () {

            Route::get('/', [ResultEntryController::class,'index'])
                ->name('results.index');

            Route::post('/load-students', [ResultEntryController::class,'loadStudents'])
                ->name('results.loadStudents');

            Route::post('/store', [ResultEntryController::class,'store'])
                ->name('results.store');

        });

});


/*
|--------------------------------------------------------------------------
| Parent Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:Parent'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('parent.dashboard'))->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:Student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('student.dashboard'))->name('dashboard');

});


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class,'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';