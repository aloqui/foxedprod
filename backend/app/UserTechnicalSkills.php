<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTechnicalSkills extends Model
{
    public function user() {
        $this->belongsTo(User::class, 'user_id');
    }
}
