<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Laravel\Scout\Jobs\MakeSearchable;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;
use App\Thread;
use Auth;

class Thread extends Model
{
    use Searchable;
    protected $guarded = [];
    protected $appends = ['isSubscribedTo'];

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public function subscribe() {
        return $this->subscriptions()->create([
            'user_id' => auth()->id()
        ]);
    }
    public function unsubscribe() {
        $this->subscriptions()
            ->where('user_id', Auth::guard('api')->id())
            ->delete();
    }
    public function subscriptions() {
        return $this->hasMany(ThreadSubscription::class);
    }
    
    public function getIsSubscribedToAttribute()
    {
       
        return $this->subscriptions()
        ->where('user_id', Auth::guard('api')->id())
        ->exists();
            
    }

    //
    public function path() {
        return "/community/{$this->channel->slug}/{$this->id}";
    }

    public function channelVal() {
        return $this->channel;
    }
    public function ownerVal() {
        return $this->owner;
    }
    public function replies() {
        return $this->hasMany(Reply::class)->withCount('favorites');
    }
    public function addReply($reply) {
        $reply = $this->replies()->create($reply);

        $this->subscriptions
            ->filter(function ($sub) use ($reply) {
                return $sub->user_id != $reply->user_id;
            })
            ->each->notify($reply);


     
        return $reply;
    }
    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id');
    }
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function subscribers() {
        return $this->hasMany(ThreadSubscription::class);
    }
    public function scopeFilter($query, $filters) {
        return $filters->apply($query);
    }
   public function recondVisit() {
       Redis::incr($this->visitsCacheKey());
       return $this;
   }

   public function visits() {
       Redis::get($this->visitsCacheKey());
        return $this;
   }
   public function resetVisits() {
    Redis::del($this->visitsCacheKey());
    return $this;
   }
   public function visitsCacheKey() {
       return "threads.{$this->id}.visits";
   }
   public function toSearchableArray() {
       return $this->toArray() + ['path' => $this->path()] + ['channel' => $this->channelVal()] + ['owner' => $this->ownerVal()]; 
   }
}
