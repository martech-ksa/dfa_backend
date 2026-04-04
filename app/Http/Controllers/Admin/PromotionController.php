<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Domains\Student\Services\PromotionService;

use App\Models\ClassArm;
use App\Models\Session;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index()
    {
        $classArms = ClassArm::with('level.program')->get();
        $sessions = Session::all();

        return view('admin.promotions.index', compact(
            'classArms',
            'sessions'
        ));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'from_class' => 'required',
            'to_class' => 'required',
            'session' => 'required'
        ]);

        $this->promotionService->promoteClass(
            $request->from_class,
            $request->to_class,
            $request->session
        );

        return redirect()
            ->back()
            ->with('success','Students promoted successfully');
    }
}