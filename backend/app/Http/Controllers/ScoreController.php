<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Classroom;
use App\User;
use App\Score;
use App\RawScore;
use Carbon\Carbon;

class ScoreController extends Controller
{
    public function create(Score $score, Request $request)
    {
        if(Auth::user()->prof == true && $request->totalScore){

        $scores = $score->create([
            // 'prof_id' => Auth::id(),
            'user_id' => request('user_id'),
            'activity_id' => request('act_id'),
            'totalScore' => request('totalScore'),
        ]);

        $now = Carbon::now('utc')->toDateTimeString();

                foreach ($request->scores as $col) {
                $dataa[] = [
                    'score_id'    => $scores->id,
                    'criteria_num'  => $col['criteria_num'],
                    'raw'    => $col['raw'],
                    'computed'    => $col['computed'],
                    'created_at'=> $now,
                    'updated_at'=> $now
                    ]; 
                }
                $raw = RawScore::insert($dataa);
        return $scores->load('raw');
    }
    }
    public function show($id){
        $score = Score::find($id);
        
        if(count($score) > 0)
            return response()->json($score->load('raw'));

        return response()->json(['error' => 'resource not found'],404);
    }
}
