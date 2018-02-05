<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    //
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function classroom(){
        return $this->belongsTo(Classroom::class)->latest();
    }
}
