<?php

namespace App\Http\Controllers;

use App\UserDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = $request->user()->load('languages', 'technicalSkills', 'details');
        $email = User::where('id', auth()->id())->firstOrFail()->email;
        return ['user' => $response , 'email' => $email];
    }

    public function basicUpdate(Request $request) {
        $user = User::where('id', auth()->id())->firstOrFail();
        $newEmail = false;
        if($user->email != request('email')) {
            $user->confirmed = 0;
            $user->confirmation_token = str_limit(md5($request['email'] . str_random()), 6, '');
            $newEmail = true;
        }
       $response = $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'. auth()->id(),
        'username' => 'required|string|min:2|max:20|unique:users,username,' . auth()->id()
       ]);
        $user->email = $request['email'];
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->save();
        if($newEmail)
            event(new Registered($user));

        return ['new_email' => $newEmail];
    }

    public function resendCode() {
        $user = User::where('id', auth()->id())->firstOrFail();
        if(!$user->confirmed) {
            $user->confirmation_token = str_limit(md5($user->email . str_random()), 6, '');
            $user->save();
            event(new Registered($user));
        }
        return $user;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function show(UserDetails $userDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(UserDetails $userDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserDetails $userDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserDetails  $userDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDetails $userDetails)
    {
        //
    }
}
