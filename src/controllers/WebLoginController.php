<?php

namespace StateOfMotion\Authentication\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class WebLoginController extends Controller
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

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loggedIn = $this->guard()->attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($loggedIn) {
            $request->session()->regenerate();
            return response()->json([
                'logged_in' => $loggedIn, 
                'token'     => csrf_token()
            ]);
        }
        return response()->json([
            'logged_in' => false,
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: response()->json([
            'logged_out' => true,
            'token'      => csrf_token()
        ]);
    }
}
