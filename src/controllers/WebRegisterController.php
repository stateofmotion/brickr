<?php

namespace StateOfMotion\Authentication\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;


class WebRegisterController extends Controller
{

    use RegistersUsers;

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        event(new Registered($user = $this->create($request->all())));

        $loginToken = $user->createToken('user-auth-token')->plainTextToken;
        
        return response()->json([
            'access_token' => $loginToken,
            'token_type'   => 'Bearer',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'] ?? null,
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
