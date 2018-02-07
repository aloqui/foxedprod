<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Recaptcha;
use App\Channel;
use Auth;

class ChannelController extends Controller
{
    //                        
    public function store(Request $request, Channel $channel, Recaptcha $recaptcha) {
        request()->validate([
            'name' => 'required|unique:channels,name|max:30',
            'slug' => 'required|unique:channels,slug|max:30',
            'description' => 'required:channels,description|max:280',
            'recaptcha' => ['required', $recaptcha]
        ]); 
        
        $postChannel = Channel::Create([
            'user_id' => Auth::id(),
            'name' => request('name'),
            'slug' => request('slug'),
            'description' => request('description'),
        ]);
        return $postChannel;
        }
}
