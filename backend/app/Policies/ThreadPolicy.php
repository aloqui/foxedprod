<?php

namespace App\Policies;

use App\User;
use App\Thread;
use App\Reply;
use App\Code;
use App\Classroom;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    // public function before($user) {
    //     if($user->name === 'aloquindo') {
    //         return true;
    //     }
    // }
    /**
     * Determine whether the user can view the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function view(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
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
    public function update(User $user, Thread $thread)
    {
        //
        return $thread->user_id == Auth::id();
    }
    public function updateReply(User $user, Reply $reply)
    {
        //
        return $reply->user_id == Auth::id();
    }
    public function createClass(User $user, Classroom $classroom)
    {
        //
        return Auth::user()->prof == 1;
    }
    public function updateCode(User $user, Code $code)
    {
        //
        return $code->user_id == Auth::id();
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        //
    }
}
