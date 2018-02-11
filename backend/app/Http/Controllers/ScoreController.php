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
        if(Auth::user()->prof == true){
        $scores = $score->create([
            // 'prof_id' => Auth::id(),
            'user_id' => request('user_id'),
            'activity_id' => request('act_id'),
            'first' => request('first'),
            'second' => request('second'),
            'third' => request('third'),
            'fourth' => request('fourth'),
            'body' => request('body'),
        ]);
        return $scores;
    }
    }
    public function show($id){
        $score = Score::find($id);
        
        if(count($score) > 0)
            return response()->json(Score::find($id));

        return response()->json(['error' => 'resource not found'],404);
    }
}
