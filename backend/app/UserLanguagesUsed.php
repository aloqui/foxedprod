<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class UserLanguagesUsed extends Model
{
    protected $table = 'user_languages_used';
    public function user() {
        $this->belongsTo(User::class, 'user_id');
    }
}
