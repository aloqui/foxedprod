<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RubricSetController extends Controller
{
    public function store(Request $request)
    {
        if(Auth::user()->prof == true) 
        $rubric = Rubrics::create(  [
            'user_id' => Auth::id(),
            'title' => request('title'),
            'for' => request('for')
        ]);
        return $rubric;
    }
}
