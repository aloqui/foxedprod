<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;
use App\Channel;
use App\Classroom;
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
    
    public function index(Channel $channel, Thread $thread) {
        if($thread->channel_id == $channel->id) {
            return $thread->replies()->with('owner')->paginate(5);
        }
        else
            return abort(403, 'Unauthorized');
    }
    public function indexClassroom(Classroom $classroom, Thread $thread) {
            return $thread->replies()->with('owner')->paginate(5);
    }
    public function store(Channel $channel, Thread $thread, Request $request) {
        
        if($thread->channel_id == $channel->id ) {
        $redis = \LRedis::connection();
        $this->validate($request, ['body' => 'required|max:800']);
        $response = $thread->addReply([
            'body' => request('body'),
            'user_id' => Auth::id()
        ])->load('owner');
        $user = auth()->user();
        $res = $redis->publish('message', $response);
        return $res;
        }
        else
            return abort(403, 'Unauthorized');

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
    public function storeToClassroom(Classroom $classroom, Thread $thread, Request $request) {
        if($classroom->getIsMemberAttribute() || $classroom->getIsOwnerAttribute()) {
            
            
            $this->validate($request, ['body' => 'required|max:800']);
            $response = $thread->addReply([
                'body' => request('body'),
                'user_id' => Auth::id()
                ])->load('owner');
                
                $user = auth()->user();
                $redis = Redis::connection();
                $redis->publish('message', $response);
                return $response;
                
                preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
                $names = $matches[0];
                
                foreach($names as $name) {
                    $user = User::whereName($name)->first();
                    
                    if($user) {
                        $user->notify(new YouWereMentioned($reply));
                    }
                }
                if(request()->expectsJson()){
                    return $reply;
                }
            
            }
        else {
            return abort(403, 'Unauthenticated');
        }
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
