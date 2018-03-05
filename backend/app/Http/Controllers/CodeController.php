<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Code;
use App\Filters\ThreadFilters;
use App\Filters;
use Auth;

class CodeController extends Controller
{
    public function index()
    {
        
        return Code::all();
    }
    
    public function store(Request $request){
       
        $code = Code::create([
            'user_id' => Auth::id(),
            'title' => request('title'),
            'html' => request('html'),
            'js' => request('js'),
            'css' => request('css'),
            'activity_id' => request('activity_id'),
            'rubric_set_id' => request('rubric_set_id'),
            'submitted' => request('submitted')
        ]);
        $user = User::find($code->user_id);
        
        return [$code , $user->username];

    }
    public function show($id){
        $code = Code::find($id);
        
        if(count($code) > 0)
            return response()->json(Code::find($id)->get());

        return response()->json(['error' => 'resource not found'],404);
    }

    public function showCertainCode($name,$id){
        $user = User::where('username', $name)->first();
        
        return $user->project()->latest()->where('id',$id)->get();
    }

    public function updateEval($id){
        $code = Code::find($id);
        
        $code->update([
            'evaluated' => 1,
            'score_id' =>  request('score_id')
        ]);
        
     return $code;
    }
    
    public function update(Code $code){
        $this->authorize('update', $code);
        
        // $code = Code::find($code);
        $code->update(request()->all());
        // $code->update(request()->validate([
        //     'title' => 'required',
        //     'html' => 'required',
        //     'css' => 'required',
        //     'js' => 'required',
        // ]));

        // $code->update($request->all());
        return response()->json($code);
    }

    public function destroy($id){
        try {
            Code::destroy($id);
            return response([],204);
        }
        catch(\Exeption $e){
            return response([ 'Problem deleting the thread' ],500);
        }
    }
    public function showCodes(User $user){

        $usercodes = $user->project()->whereNull('activity_id')->get();
        $usercodess = $user->project()->where('evaluated', true)->get();
        $cods = $usercodes->merge($usercodess);

        $userimage = $user->imagesport()->whereNull('activity_id')->get();
        $userimages = $user->imagesport()->where('evaluated', true)->get();
        $imgs = $userimage->merge($userimages);

        return [$profileUser = $user, 'codes' => $cods, 'images' => $imgs ];
    }
}
// return [$profileUser = $user, 'codes' => $user->project()->latest()->where('activity_id', null)->orWhere('evaluated', true)->get(), 
//         'images' => $user->imagesport()->latest()->where('activity_id', null)->orWhere('evaluated', true)->get()