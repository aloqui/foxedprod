<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubricSet extends Model
{
    protected $guarded = [];
    
    public function row() {
        return $this->belongsTo(rubrics::class, 'rubric_set_id');
    }
}
