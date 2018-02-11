<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesPortfolio extends Model
{
    protected $guarded = [];
    public function user() {
        return $this->belongsTo(User::class );
    }
    public function scores() {
        return $this->hasMany(Score::class,'activity_id');
    }
    public function score() {
        return $this->belongsTo(Score::class);
    }
}
