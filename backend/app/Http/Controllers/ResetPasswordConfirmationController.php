<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ResetPasswordConfirmationController extends Controller
{
    public function reset(Request $request) {
        $this->validate($request, [
            'token' => 'required|min:8',
            'password' => 'required|min:6|max:50',
            'passwordConfirm' => 'required|min:6|max:50'
            ]);
         if (request('password') != request('passwordConfirm')) {
                abort(401, 'Passwords do not match.');
        }
        $user = User::where('reset_password_token', request('token'))
            ->firstOrFail();
        $user->password = bcrypt(request('password'));
        $user->reset_password_token = null;
        $user->save();
    }
}
