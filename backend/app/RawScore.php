<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RawScore extends Model
{
    protected $guarded = [];
    public function score() {
        return $this->belongsTo(Score::class);
    }
}
