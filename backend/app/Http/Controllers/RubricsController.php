<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Activity;
use App\RubricDetails;
use App\User;
use App\rubrics;
use App\RubricSet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RubricsController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->prof == true){

            // try {
                // $v = Validator::make($request->all(), [
                //     'title' => 'required|unique|max:255',
                //     'criteria' => 'required',
                //     'percent' => 'required',
                // ]);
                
                if( $request->title && $request->percent  && $request->criteria){

                $rubric = RubricSet::create([
                'user_id' => Auth::id(),
                'title' => request('title')
                ]);

                $criteria = Rubrics::create([
                'rubric_set_id' => $rubric->id,
                'criteria' => request('criteria'),
                'percent' => request('percent') 
                ]);

                $now = Carbon::now('utc')->toDateTimeString();
                foreach ($request->col as $col) {
                $dataa[] = [
                    'description'  => $col['description'],
                    'col_num'    => $col['col_num'],
                    'rubric_id'   =>$criteria->id,
                    'created_at'=> $now,
                    'updated_at'=> $now
                    ]; 
                    
                }
                $questions = RubricDetails::insert($dataa);
                    return $rubric->load('row','row.col');
                }
            //   }
            //   catch (\Exception $e) {
                // return $e->getMessage();
            // }
            // if($criteria->isEmpty()){
            //     RubricSet::destroy($rubric->id); 
            // }
        else {
            return response()->json(['warning' => 'fill up the required field'],404);
        }
        }

        
    }
    public function storeRow(Request $request)
    {
        if(Auth::user()->prof == true){

            $criteria = Rubrics::create(  [
            'rubric_set_id' => request('rubric_set_id'),
            'criteria' => request('criteria'),
            'percent' => request('percent')
        ]);

        $now = Carbon::now('utc')->toDateTimeString();
            foreach ($request->col as $col) {
            $dataa[] = [
                'description'  => $col['description'],
                'col_num'    => $col['col_num'],
                'rubric_id'   =>$criteria->id,
                'created_at'=> $now,
                'updated_at'=> $now
            ]; 
        }
        $questions = RubricDetails::insert($dataa);
        }
        $rubric = RubricSet::find($criteria->rubric_set_id);

        return $rubric->load('row','row.col');
    }

    public function updateColumn(Request $request,$id)
    {
        $column = RubricDetails::find($id);

        if(Auth::user()->prof == true){
            $column->update([
            'description' => request('description') 
            ]);
        }
        
        
        return response()->json($column);
    }

    public function destroy($id){
        $row = Rubrics::find($id);
        $rub = RubricSet::find($row->rubric_set_id);
        if(Auth::user()->prof == true && $rub->used == false){

            try {
            Rubrics::destroy($id);
            return response([],204);
            }
            catch(\Exeption $e){
                return response([ 'Problem deleting the criteria' ],500);
            }
            
        }
        else{
            return response([ 'you already used this rubric' ],500);
        }
        
    }

    public function updateRow(Request $request,$id)
    {
        $row = Rubrics::find($id);
        $rub = RubricSet::find($row->rubric_set_id);

        if(Auth::user()->prof == true && $rub->used == false){
            $row->update([
            'percent' => request('percent'),
            'criteria' => request('criteria') 
            ]);
        }
        
        else{
            return response([ 'you already used this rubric' ],500);
        }
        
        
        return response()->json($row);
    }

    public function updateUse(Request $request,$id)
    {
        $row = RubricSet::find($id);

        if(Auth::user()->prof == true){
            $row->update([
            'used' => request('used')
            ]);
        }
        
        
        return response()->json($row);
    }


    public function showRubrics($name){
        $user = User::where('username', $name)->first();
        
        $rub = $user->rubs()->get();

        $col = $rub->load('row','row.col');
 
        return ['rubric' => $col];
 
    } 
    public function showCertRubric($id){
        $user = RubricSet::find($id);

        $col = $user->load('row','row.col');
 
        return ['rubric' => $col];
 
    } 

    public function show($id){
        $rubric = Rubrics::find($id);
        
        if(count($rubric) > 0)
            return response()->json(Rubrics::find($id)->load('details'));

        return response()->json(['error' => 'resource not found'],404);
    }

    public function showRubricOwn(User $user){
        // $rubric = Rubrics::where('user_id', $id); 
        $user->rubs()->get();

        return response()->json($user);
    }
}
