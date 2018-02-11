<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(RegisterRequest $request)
    {
        event(new Registered(
        $user = User::forceCreate([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'username' => $request['username'],
            'prof' => $request['prof'],
            'confirmation_token' => str_limit(md5($request['email'] . str_random()), 6, ''),
            'reset_password_token' => null
        ])));
        UserDetails::forceCreate([
            'user_id' => $user->id,
            'birth_date' => $request['birth_date']
        ]);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'succesfully registered',
        // ]);
        
    }
    
}
