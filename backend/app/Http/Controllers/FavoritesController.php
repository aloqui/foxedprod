<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FavoritesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function store(Reply $reply) {
        $response = $reply->favorite();
        $redis = Redis::connection();
        $redis->publish('favoriteReply', $response);
        return $response;
    }
}
