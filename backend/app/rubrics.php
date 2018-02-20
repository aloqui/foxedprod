<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubrics extends Model
{
    protected $guarded = [];
    
    public function col() {
        return $this->hasMany(RubricDetails::class,'rubric_id');
    }
}
