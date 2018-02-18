<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Classroom;
use App\Code;
use App\Score;
use App\ImagesPortfolio;
use App\RubricSet;
use Auth;

class ActivityController extends Controller
{
    public function index() 
    {
        // $forums = Forum::latest()->get();
        // return view('threads.index', compact('forums') );
        return Activity::all();
    }

    public function store(Request $request){
        if($request->image){


            $exploded = explode(',', $request->image);

            $decoded = base64_decode($exploded[1]);

            if(str_contains($exploded[0],'jpeg'))
                $extension = 'jpg';
            else
                $extension ='png';

            $fileName = str_random().'.'.$extension;
            $path = public_path().'/images/'.$fileName;
            
            file_put_contents($path, $decoded);
            
        }
        else{
            $fileName = 'none';
        }
        $activity = Activity::create( $request->except('image') + [
            'user_id' => Auth::id(),
            'title' => request('title'),
            'body' => request('body'),
            'rubric_set_id' => request('body'),
            'image' => $fileName
        ]);

        return $activity;
    }
    public function show($id){
        $activity = Activity::find($id);
        
        if(count($activity) > 0)
            return response()->json(Activity::find($id));

        return response()->json(['error' => 'resource not found'],404);
    }

    public function getCertRubric($id){
        $activity = Activity::find($id);
        
        $act = $activity->id;
        
        $rub = RubricSet::find($act);

        $rubric = $rub->load('row','row.col');
        
        return $rubric;
    }

    public function update(Request $request, $id){
        $activity = Activity::find($id);
        if($activity->isProf || $activity->user_id == Auth::id()) {
            if($request->newImage){
                if(file_exists(public_path("images/{$request->oldImage}"))){
                    unlink((public_path('images/' . $request->oldImage)));
                }
            }
            if($request->newImage){
                    $exploded = explode(',', $request->newImage);
                    $decoded = base64_decode($exploded[1]);
        
                    if(str_contains($exploded[0],'jpeg'))
                        $extension = 'jpg';
                    else
                        $extension ='png';
        
                    $fileName = str_random().'.'.$extension;
                    $path = public_path().'/images/'.$fileName;
                    file_put_contents($path, $decoded);
                }
                else{
                    $fileName = $request->oldImage;
                }

                $activity->update( $request->except('image','oldImage','newImage') + [
                        'title' => request('title'),
                        'body' => request('body'),
                        'due' => request('due'),
                        'image' => $fileName
                    ]
                );
                return response()->json($activity);
            
        }
        else{
            return response()->json(['Unauthorized' => 'Not allowed to perform this operation'],404);
        }
        
    }

    public function updateTime(Request $request, $id){
        $forum = Activity::find($id);

        $forum->update($request->all());
        return response()->json($forum);
    }

    public function destroy($id){
        $file = Activity::find($id);
            if($file->image){
                if(file_exists(public_path("images/{$file->image}"))){
                    unlink((public_path('images/' . $file->image)));
                }
            }
        try {
            Activity::destroy($id);
            return response([],204);
        }
        catch(\Exeption $e){
            return response([ 'Problem deleting the thread' ],500);
        }
    }

    public function showActivities(Classroom $classroom){
        return [$profileUser = $classroom, 'activities' => $classroom->classPosts()->latest()->get()];
    } 
    public function evaluationCodes($Actid){
        $codes = Activity::find($Actid);
        // $codes->CodesSubmitted->load('scores');
        // $scores->ScoresSubmitted->load('user');

        // $codes->CodesSubmitted->load('user');
        // $codes->ScoresSubmitted->load('user');
        return [
        'userAct' => $codes->CodesSubmitted->load('user','score.raw'),
        'score' => $codes->ScoresSubmitted->load('user'),
        'userImage' => $codes->ImageSubmitted->load('user','score.raw'), 
        'class'=> $codes];
        // return $codes->ScoresSubmitted->load('owner');
        return $codes;
    }
}
