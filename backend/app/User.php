<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','prof',
        'avatar_path'
    ];
    protected $appends = ['isProf'];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'confirmation_token'
    ];
    protected $casts = [
        'confirmed' => 'boolean'
    ];
    protected static function boot() {
        parent::boot();

        static::addGlobalScope('classCount', function ($builder) {
            $builder->withCount('classes');
        });
    
    }
    public function getRouteKeyName() {
        return 'username';
    }
    public function confirm() {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }
    public function getAvatarPathAttribute($avatar){
        return asset($avatar ? 'storage/' . $avatar : 'storage/avatars/default.jpg');
    }
    public function threads() {
        return $this->hasMany(Thread::class)->latest();
    }
    public function languages() {
        return $this->hasMany(UserLanguagesUsed::class)->latest();
    }
    public function technicalSkills() {
        return $this->hasMany(UserTechnicalSkills::class)->latest();
    }
    public function details() {
        return $this->hasOne(UserDetails::class)->latest();
    }
    public function prof() {
        return $this->hasMany(Classroom::class)->latest();
    }
    public function channel() {
        return $this->hasMany(Channel::class);
    }
    public function classes() {
        return $this->hasMany(Classroom::class)->latest();
    }
    public function project() {
        return $this->hasMany(Code::class)->latest();
    }
    public function imagesport() {
        return $this->hasMany(ImagesPortfolio::class)->latest();
    }
    public function getIsProfAttribute() {
        return $this->prof()
            ->where('user_id', auth()->id())
            ->exists();
    }
    
}
