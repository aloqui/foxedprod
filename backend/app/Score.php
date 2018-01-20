<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
        protected $guarded = [];
        public function user() {
            return $this->belongsTo(User::class);
        }
        public function ScoresSubmitted() {
            return $this->hasMany(Activity::class);
        }
}
