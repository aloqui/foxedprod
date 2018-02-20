<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
        protected $guarded = [];
        public function user() {
            return $this->belongsTo(Activity::class);
        }
        public function ScoresSubmitted() {
            return $this->belongsTo(Activity::class);
        }
        public function raw() {
            return $this->hasMany(RawScore::class);
        }
}
