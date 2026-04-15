<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id'
        ]);

        $selectedRole = Role::findOrFail($request->role_id);

        // 🚨 Prevent admin from removing their own admin role
        if (
            Auth::id() === $user->id &&
            !$selectedRole->name === 'admin'
        ) {
            return back()->with('error', 'You cannot remove your own admin role.');
        }

        // Additional safety: if current user is admin and changing self
        if (
            Auth::id() === $user->id &&
            $selectedRole->name !== 'admin'
        ) {
            return back()->with('error', 'You cannot downgrade your own account.');
        }

        $user->roles()->sync([$selectedRole->id]);

        return back()->with('success', 'Role updated successfully.');
    }
}