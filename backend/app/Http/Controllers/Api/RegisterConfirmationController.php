<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegisterConfirmationController extends Controller
{
    //
    public function index(Request $request) {
        $this->validate($request, ['token' => 'required']);
        return User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();
        //return redirect('/#/register/confirmation?token=' . request('token'));
    }
}
