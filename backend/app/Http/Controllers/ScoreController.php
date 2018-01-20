<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Classroom;
use App\User;
use App\Score;

class ScoreController extends Controller
{
    public function create(Score $score)
    {
        if(Auth::user()->prof == true) 
        $score->create([
            // 'prof_id' => Auth::id(),
            'user_id' => request('user_id'),
            'activity_id' => request('act_id'),
            'body' => request('body'),
        ]);
    }
}
