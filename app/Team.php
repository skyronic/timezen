<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'join_token'];

    public function users () {
        return $this->belongsToMany(User::class);
    }

    public function admins () {
        return $this->belongsToMany(User::class, 'team_admins', 'team_id', 'user_id');
    }

    public function addAdmin (User $user) {
        $this->admins()->attach($user);
    }

    public function inviteLink () {
        return url()->route('join_team', $this->join_token);
    }

    /**
     * @param $user User
     */
    public function toggleAdmin ($user) {
        $this->admins()->toggle([$user->id]);
        $this->save();
    }

    public function addUser (User $user) {
        $this->users()->attach($user);
        $this->save();
    }
}
