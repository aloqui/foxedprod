<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show() {

        $search = request('q');
        $threads = Thread::search($search)->paginate(25);

        
        return $threads->load('channel', 'owner', 'replies');
    }
    public function showChannel() {

        $search = request('q');
        $channels = Channel::search($search)->paginate(5);
        
        return $channels;
        

        // return something
    }
}
