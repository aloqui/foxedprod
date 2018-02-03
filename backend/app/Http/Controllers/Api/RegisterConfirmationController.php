<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegisterConfirmationController extends Controller
{
    //
    public function index() {
        return User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();

        //return redirect('/#/register/confirmation?token=' . request('token'));
    }
    public function resetPassword() {
        User::where('reset_password_token', request('token'))
             ->firstOrFail()
             ->reset();
 
        //  return redirect('/#/register/confirmation?token=' . request('token'));
     }
}
