<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'join_token'];

    public function users () {
        return $this->belongsToMany(User::class);
    }
}
