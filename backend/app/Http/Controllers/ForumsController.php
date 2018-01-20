<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;
use Auth;


class ForumsController extends Controller
{
    //
    public function index()
    {
        // $forums = Forum::latest()->get();
        // return view('threads.index', compact('forums') );
        return Forum::all();
    }

    public function store(Request $request){
        $exploded = explode(',', $request->image);

        $decoded = base64_decode($exploded[1]);
        if(str_contains($exploded[0],'jpeg'))
            $extension = 'jpg';
        else
            $extension ='png';

        $fileName = str_random().'.'.$extension;
        $path = public_path().'/'.$fileName;

        file_put_contents($path, $decoded);

        $forums = Forum::create($request->except('image') + [
        'user_id' => Auth::id(),
        'image' => $fileName
        ]);

        return $forums;
    }
    public function show($id){
        $forum = Forum::find($id);
        
        if(count($forum) > 0)
            return response()->json(Forum::find($id));

        return response()->json(['error' => 'resource not found'],404);
    }

    public function update(Request $request, $id){
        $forum = Forum::find($id);

        $forum->update($request->all());
        return response()->json($forum);
    }

    public function destroy($id){
        try {
            Forum::destroy($id);
            return response([],204);
        }
        catch(\Exeption $e){
            return response([ 'Problem deleting the thread' ],500);
        }
    }
}
