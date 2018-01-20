<?php

namespace App\Policies;

use App\User;
use App\Code;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class EditorPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
        /**
     * Determine whether the user can update the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function update(User $user, Code $code)
    {
        return $code->user_id == Auth::id();
    }
}
