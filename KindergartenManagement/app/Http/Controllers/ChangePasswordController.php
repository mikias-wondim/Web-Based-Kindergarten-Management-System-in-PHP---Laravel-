<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    public function show()
    {
        return view('auth.password-change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches the user's actual password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        if ($request->input('password') == 'changeme'){
            throw ValidationException::withMessages([
                'password' => 'The new password can not be same with old password.',
            ]);
        }

        // Update the password with the new one
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $role = auth()->user()->role;
        $redirectTo =  match ($role) {
            'child' => '/home',
            'teacher' => '/teacher-dashboard',
            'system admin' => '/admin-dashboard',
            'accountant' => '/accountant-dashboard',
            'school director' => '/director-dashboard',
            'reception' => '/reception-dashboard',
            default => '/',
        };

        return redirect($redirectTo)->with('success', 'Password updated successfully.');
    }
}
