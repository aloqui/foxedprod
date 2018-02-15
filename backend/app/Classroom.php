<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classroom;
use Laravel\Scout\Jobs\MakeSearchable;
use Laravel\Scout\Searchable;
use Auth;
class Classroom extends Model
{
    use Searchable;
    //
    protected $guarded = [];
    protected $appends = ['isMember', 'isOwner'];

    // protected $hidden = ['isMember', 'isOwner'];
   
    public function subscribe($userId = null) {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }
    public function unsubscribe($userId = null) {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }
    public function subscriptions() {
        return $this->hasMany(UserGroup::class);
    }
    
    public function getIsMemberAttribute() {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
    public function getIsOwnerAttribute() {
        return $this
            ->where('user_id', Auth::id())
            ->exists();
    }
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function members() {
        return $this->hasMany(UserGroup::class);
    }
    public function ownCodes() {
        return $this->hasMany(Code::class);
    }
    public function announcements() {
        return $this->hasMany(UserGroup::class);
    }
    public function assignments() {
        return $this->hasMany(UserGroup::class);
    }
    public function files() {
        return $this->hasMany(UserGroup::class);
    }
    public function classPosts() {
        return $this->hasMany(Activity::class);
    }
    
}