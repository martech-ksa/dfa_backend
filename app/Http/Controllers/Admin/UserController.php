<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (SEARCH + PAGINATION)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'search'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE STAFF
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|string|exists:roles,name',
        ]);

        $password = Str::random(8);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        return back()->with([
            'success' => '✅ Staff created successfully',
            'password' => $password
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ROLE
    |--------------------------------------------------------------------------
    */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);

        // Prevent self downgrade
        if (Auth::id() === $user->id && $validated['role'] !== 'Admin') {
            return back()->with('error', '❌ You cannot downgrade yourself.');
        }

        $user->syncRoles([$validated['role']]);

        return back()->with('success', '✅ Role updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ENABLE / DISABLE USER
    |--------------------------------------------------------------------------
    */
    public function toggleStatus(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', '❌ You cannot disable yourself.');
        }

        // Prevent disabling last admin
        if ($user->hasRole('Admin') && User::role('Admin')->count() <= 1) {
            return back()->with('error', '❌ Cannot disable last admin.');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return back()->with('success', '✅ User status updated');
    }

    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD (ADMIN)
    |--------------------------------------------------------------------------
    */
    public function resetPassword(User $user)
    {
        $newPassword = Str::random(8);

        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return back()->with([
            'success' => '✅ Password reset successfully',
            'password' => $newPassword
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE USER
    |--------------------------------------------------------------------------
    */
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', '❌ You cannot delete yourself.');
        }

        if ($user->hasRole('Admin') && User::role('Admin')->count() <= 1) {
            return back()->with('error', '❌ Cannot delete last admin.');
        }

        $user->delete();

        return back()->with('success', '✅ User deleted successfully');
    }
}