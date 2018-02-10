<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\ResetPassword; 
use Illuminate\Http\Request;
use App\User;

class ResetPasswordController extends Controller
{

    protected function index(User $userData, Request $request) {
        $this->validate($request, [
            'email' => 'required'
            ]);
        $userData = User::where('email', $request['email'])->firstOrFail();
        $user = $userData->reset_password_token = str_limit(md5($request['email'] . str_random()), 12, '');
        $userData->save();
        event(new ResetPassword($userData));
        }
}
