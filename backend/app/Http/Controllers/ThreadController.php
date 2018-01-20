<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\Filters\ThreadFilters;
use App\Filters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Auth;


class ThreadController extends Controller
{
    public function __contruct() {
        $this->middleware('auth')->except('index', 'show', 'showChannels');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, Thread $threads, ThreadFilters $filters)
    {
        
        //
    //    $threads = $this->getThreads($channel);
       //$threads = (new ThreadsQuery)->get();
      // 
       if ($channel->exists) {
        //$channelId = Channel::where('slug', $channelSlug)->first()->id;
       // $threads = Thread::where('channel_id', $channelId)->latest()->get();
       $threads = $channel->threads()->latest();
      
    } else {
        //$threads = Thread::latest()->filter($filters);  
    }
    //$threads = Thread::filter($filters);

    // $trending = array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4));
    $threads = $threads->get()->load('channel', 'owner', 'replies');
    return 
        $threads
        // $trending
;
    }
    public function showChannels(Channel $channel) {
        $channel = Channel::latest()->get()->load('threads');
        return $channel;
    }
    public function showOwnThreads(Channel $channel, User $user) {
       
        return [$profileUser = $user, 'threads' => $user->threads()->latest()->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('threads')
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // request()->validate([
        //     'title' => 'required',
        //     'body' => 'required',
        //     'channel_id' => 'required|exists:channels,id'
        // ]);
        // Thread::Create([
        //     'user_id' => Auth::id(),
        //     'title' => request('title'),
        //     'channel_id' => 23,
        //     'body' => request('body')
        // ]);
      
    }
    public function storeThreadOnChannel(Request $request, Channel $channel) {

        
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]); 
        Thread::Create([
            'user_id' => Auth::id(),
            'title' => request('title'),
            'channel_id' => request('channel_id') ,
            'body' => request('body')
        ]);
        
        
    }
    
    public function getThisChannel(Request $request, Channel $channel, Thread $thread) {
        return $channel;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        
        $thread->load('owner', 'subscriptions', 'channel');

        // Redis::zincryby('threading_threads', 1, json_encode([
        //     'title' => $thread->title,
        //     'path' => $thread->path()
        // ]));

        return $thread;
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update($channel, Thread $thread)
    {
        //authorization
        //validation
        //update the thread
        $this->authorize('update', $thread);
        $thread->update(request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]));
        return $thread;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->replies()->delete();
        $thread->delete();

        if ($thread->user_id != Auth::id()) {
            abort(401, 'You do not have permission to do this.');
        }
        
        return response([], 204);
    }

    protected function getThreads(Channel $channel, User $user) {
        
    }
}