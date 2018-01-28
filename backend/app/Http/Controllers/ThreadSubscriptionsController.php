<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use Illuminate\Support\Facades\Redis;

class ThreadSubscriptionsController extends Controller
{
        

        public function store($channelId, Thread $thread)
        {
            
            $response = $thread->subscribe();
            $redis = Redis::connection();
            $redis->publish('subscribe', $response);
        }
    


    public function destroy($channelId, Thread $thread)
       {
            $thread->unsubscribe();
       }
}