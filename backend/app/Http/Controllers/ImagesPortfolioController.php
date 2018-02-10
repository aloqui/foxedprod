<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImagesPortfolio;
use Auth;

class ImagesPortfolioController extends Controller
{
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
        $activity = ImagesPortfolio::create( $request->except('image') + [
            'user_id' => Auth::id(),
            'title' => request('title'),
            'image' => $fileName
        ]);

        return $activity;
    }

    public function destroy($id){
        try {
            $file = ImagesPortfolio::find($id);
            if($file->image){
                if(file_exists(public_path("images/{$file->image}"))){
                    unlink((public_path('images/' . $file->image)));
                }
            }
            ImagesPortfolio::destroy($id);
            return response([],204);
        }
        catch(\Exeption $e){
            return response([ 'Problem deleting the thread' ],500);
        }
    }

    public function update(Request $request, $id){
        $imageportfolio = ImagesPortfolio::find($id);
        if($imageportfolio->user_id == Auth::id()) {
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

                $imageportfolio->update( $request->except('image','oldImage','newImage') + [
                        'title' => request('title'),
                        'image' => $fileName
                    ]
                );
                return response()->json($imageportfolio);
            
        }
        else{
            return response()->json(['Unauthorized' => 'Not allowed to perform this operation'],404);
        }
        
    }


    public function updateEval($id){
        $code = ImagesPortfolio::find($id);
        
        $code->update([
            'evaluated' => 1,
            'score_id' =>  request('score_id')
        ]);
        
     return $code;
    }
}
