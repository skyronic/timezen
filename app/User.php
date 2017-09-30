<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'timezone', 'day_start', 'ideal_start', 'ideal_end', 'day_end'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'profile_saved' => 'boolean'
    ];

    public function teams() {
        return $this->belongsToMany(Team::class);
    }

    public function starred () {
        return $this->belongsToMany(User::class, 'stars', 'user_id', 'target_id');
    }

    public function custom () {
        return $this->hasMany(CustomTracker::class);
    }

}
