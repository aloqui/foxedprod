<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Filters;
use Auth;
use App\Activity;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Classroom $classrooms)
    {
        //
        if(Auth::user()->prof == true)  {
            $classroom = Classroom::all()->where('user_id', Auth::id());
            return $classroom;
        } 
            $classroom = Classroom::all()->where('isMember', true);
            return $classroom;
        
       
        //return ['classrooms' => $user->classes()->latest()->get()->load('owner')];
    }

    public function showTimeline(Classroom $classrooms)
    {
        //
        if(Auth::user()->prof == true)  {
            $classroom = Classroom::all()->where('user_id', Auth::id())->load('classPosts');
            // $class = Activity::all()->where('classroom_id',Auth::id());
            // $classroom->classPosts->load('activities');
            $classrooms->classPosts->load('owner');
            return $classroom;
        }
            $classroom = Classroom::all()->where('isMember', true)->load('classPosts');
            return $classroom;
        
        
        //return ['classrooms' => $user->classes()->latest()->get()->load('owner')];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, Classroom $classroom, Request $request)
    {
       if(Auth::user()->prof == true) 
       return $classroom->create([
            'user_id' => Auth::id(),
            'name' => request('name'),
            'body' => request('body'),
        ]);
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
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
        if($classroom->isMember || $classroom->user_id == Auth::id()) {
        $classroom->with('members');
        $classroom->members->load('user');
        return $classroom;
    }
}

    public function showActs($Actid)
    {
        $class = Classroom::find($Actid);
        return $class->classPosts;
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        //
    }
}