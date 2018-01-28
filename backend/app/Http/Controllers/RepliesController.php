<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;
use App\User;
use Auth;
use Illuminate\Support\Facades\Redis;

class RepliesController extends Controller
{
    // function index(){
    //     return Reply::all();
    // }
    public function __construct() {
        $this->middleware('auth', ['except' => 'index']);
    }
    
    public function index($channelId, Thread $thread) {
        return $thread->replies()->with('owner')->paginate(5);
    }
    public function store($channelId, Thread $thread, Request $request) {
        $this->validate($request, ['body' => 'required']);
        
        $response = $thread->addReply([
            'body' => request('body'),
            'user_id' => Auth::id()
        ])->load('owner');
        
        $user = auth()->user();
        $redis = Redis::connection();
        $redis->publish('message', $response);
        
        
        return $response;

        // preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
        // $names = $matches[0];

        // foreach($names as $name) {
        //     $user = User::whereName($name)->first();

        //     if($user) {
        //         $user->notify(new YouWereMentioned($reply));
        //     }
        // }
        // if(request()->expectsJson()){
           // return $reply;
        // }
    }
    public function update(Reply $reply) {
        $this->authorize('updateReply', $reply);
        $reply->update(['body' => request('body')]);
    }
    public function destroy(Reply $reply) {
        $this->authorize('updateReply', $reply);
        $reply->delete();

        if(request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        
    }
}
