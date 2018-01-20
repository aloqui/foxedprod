<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserAvatarController extends Controller
{
    //
    public function show(User $user) {
        return $user;
    }
    public function store(User $user) {
        $this->validate(request(), [
            'avatar' => ['required', 'image']
        ]);
        $user->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }
}
