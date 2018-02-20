<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RubricDetails extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(Rubrics::class);
    }
}
