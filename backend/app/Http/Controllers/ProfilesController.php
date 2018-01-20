<?php

namespace App\Http\Controllers;
use App\User;
use App\Profile;
use App\Channel;

use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    //
    public function show(User $user) {
        return [$profileUser = $user, 'threads' => $user->threads()->latest()->get()];
    }
    public function showOwnThreads(User $user, Channel $channel) {

        return ['user' => $user, $user->threads()->latest()->get()->load('channel', 'replies')];
    }
   
}
