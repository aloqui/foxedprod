<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function show() {

        if (request()->expectsJson()) {
            return Thread::search(request('q'))->paginate(25);
        }
        
        return $threads->load('channel', 'owner', 'replies');
        

        // return something
    }
    public function showChannel() {
        // $search = request('q');
        // $channels = Channel::search($search)->paginate(5);   
        if (request()->expectsJson()) {
            return Channel::search(request('q'))->paginate(25);
        }     
        return $channels;
        

        // return something
    }
}
