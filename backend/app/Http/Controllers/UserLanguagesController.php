<?php

namespace App\Http\Controllers;

use App\UserLanguagesUsed;
use Illuminate\Http\Request;

class UserLanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        
        $post = UserLanguagesUsed::Create([
            'user_id' => auth()->id(),
            'language' => request('language')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLanguages  $userLanguages
     * @return \Illuminate\Http\Response
     */
    public function show(UserLanguages $userLanguages)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLanguages  $userLanguages
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLanguages $userLanguages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLanguages  $userLanguages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLanguages $userLanguages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLanguages  $userLanguages
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLanguages $userLanguages)
    {
        //
    }
}
