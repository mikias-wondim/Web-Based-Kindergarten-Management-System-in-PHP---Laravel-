<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function sendFailedLoginResponse(Request $request, $message = 'These credentials do not match our records.')
    {
        $user = $this->guard()->getProvider()->retrieveByCredentials($this->credentials($request));

        // Check if the user's status is not 'active'
        if ($user && $user->status !== 'active') {
            $message = 'Your account is not active.';
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }


    protected function authenticated(Request $request, $user): \Illuminate\Http\RedirectResponse
    {
        // Check if the user's password is the default 'changeme'
        if (Hash::check('changeme', $user->password)) {
            return redirect()->route('password.change');
        }

        // Redirect the user to the intended page after successful login
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        $role = auth()->user()->role;

        return match ($role) {
            'child' => '/home',
            'teacher' => '/teacher-dashboard',
            'system admin' => '/admin-dashboard',
            'accountant' => '/accountant-dashboard',
            'school director' => '/director-dashboard',
            'reception' => '/reception-dashboard',
            default => '/',
        };
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

}
