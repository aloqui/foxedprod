<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Jobs\MakeSearchable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Channel extends Model
{
    //
    use Searchable;
    protected $guarded = [];
    protected static function boot() {
        parent::boot();

        static::addGlobalScope('threadCount', function ($builder) {
            $builder->withCount('threads');
        });
    }
    public function getRouteKeyName() {
        return 'slug';
    }
    public function path() {
        return "/community/{$this->slug}";
    }
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function threads() {
        return $this->hasMany(Thread::class);
    }
    public function ownerVal() {
        return $this->owner;
    }
    public function toSearchableArray() {
        return $this->toArray() + ['path' => $this->path()] + ['owner' => $this->ownerVal()]; 
    }
}
