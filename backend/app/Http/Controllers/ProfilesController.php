<?php

namespace App\Http\Controllers;
use App\User;
use App\Profile;
use App\Channel;
use DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

class ProfilesController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client = DB::table('oauth_clients')->where('id', 2)->first();
    }

    protected function authenticate(Request $request)
    {
        $request->request->add([
            'username' => $request->username,
            'password' => $request->password,
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => '*'
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return Route::dispatch($proxy);
    }
    
    //
    public function show(User $user) {
        return [$profileUser = $user, 'threads' => $user->threads()->latest()->get()];
    }
    public function showOwnThreads(User $user, Channel $channel) {

        return ['user' => $user, $user->threads()->latest()->get()->load('channel', 'replies')];
    }

    

}
