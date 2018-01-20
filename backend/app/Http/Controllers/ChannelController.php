<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Auth;
class ChannelController extends Controller
{
    //                        
    public function store(Request $request, Channel $channel) {
        request()->validate([
            'name' => 'required|unique:channels,name',
            'slug' => 'required|unique:channels,slug',
            'description' => 'required:channels,description'
        ]); 
        Channel::Create([
            'user_id' => Auth::id(),
            'name' => request('name'),
            'slug' => request('slug'),
            'description' => request('description'),
        ]);
        }
    
}
