<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\Classroom;
use App\UserGroup;
use App\Filters\ThreadFilters;
use App\Filters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Rules\Recaptcha;

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
    return ['thread' => $threads] + ['channel' => $channel];
        // $trending

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

    public function storeThreadOnChannel(Request $request, Channel $channel, Recaptcha $recaptcha) {
        request()->validate([
            'title' => 'required|max:60',
            'body' => 'required|min:10|max:1600',
            'channel_id' => 'required|exists:channels,id',
            'recaptcha' => ['required', $recaptcha]
        ]); 
        $postThread = Thread::Create([
            'user_id' => Auth::id(),
            'title' => request('title'),
            'channel_id' => request('channel_id'),
            'body' => request('body')
        ]);
        $channel = Channel::where('id', $postThread->channel_id)->firstOrFail();
        $channel->update([
            'threads_count' => $channel->threads_count + 1
        ]);
        $postThread->subscribe();
        return $postThread;
        
    }
    public function storeThreadOnClassroom($classroomId, Request $request, Recaptcha $recaptcha) {
        request()->validate([
            'title' => 'required|max:60',
            'body' => 'required|min:4|max:1600',
            'recaptcha' => ['required', $recaptcha]
        ]); 
        $matchThese = ['classroom_id' => $classroomId, 'user_id' => auth()->id()];
        $member = UserGroup::where($matchThese)->exists();
        $classroom = Classroom::where('id', $classroomId)->firstOrFail();
        if($member || $classroom->user_id == auth()->id()) {

            $postThread = Thread::Create([
                'user_id' => Auth::id(),
                'title' => $request['title'],
                'classroom_id' => $classroom->id,
                'body' => $request['body']
                ]);
                $redis = Redis::connection();
                $redis->publish('addThread', $postThread);
                return $postThread;
            }
            else
                abort(403, 'Unauthenticated');
    }
    
    public function getThisChannel(Request $request, Channel $channel, Thread $thread) {
        return $channel;
    }
    public function getThisClassroomDiscussions($channelId) {
        $getThread = Thread::where('classroom_id', $classroom->id)->load('owner', 'replies')->latest()->get();
        return $getThread;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {   
        
        if($thread->channel_id == $channel->id ) {
            $thread->load('owner', 'subscriptions', 'channel')->get();
            // Redis::zincryby('threading_threads', 1, json_encode([
                //     'title' => $thread->title,
                //     'path' => $thread->path()
                // ]));
                return $thread;
            }
        else
            return abort(403, 'Unauthorized');
        

        //
    }
    public function showOnClassroom($classroomId, Thread $thread)
    {   
        
        
        $matchThese = ['classroom_id' => $classroomId, 'user_id' => auth()->id()];
        $member = UserGroup::where($matchThese)->exists();
        $classroom = Classroom::where('id', $classroomId)->firstOrFail();
        if($member || $classroom->user_id == auth()->id()) {
            $thread->load('owner', 'subscriptions', 'channel')->get();
            // Redis::zincryby('threading_threads', 1, json_encode([
                //     'title' => $thread->title,
                //     'path' => $thread->path()
                // ]));
                return $thread;
            }
        else
            return abort(403, 'Unauthorized');
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
            'title' => 'required|max:60',
            'body' => 'required|max:1600'
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
        $channel = Channel::where('id', $thread->channel_id)->firstOrFail();
        $channel->update([
            'threads_count' => $channel->threads_count - 1
        ]);
        if ($thread->user_id != Auth::id()) {
            abort(401, 'You do not have permission to do this.');
        }
        
        return response([], 204);
    }

    protected function getThreads(Channel $channel, User $user) {
        
    }
}