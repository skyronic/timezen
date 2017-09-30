<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomTracker extends Model
{
    //
    protected $fillable = [
        'name', 'timezone', 'day_start', 'ideal_start', 'ideal_end', 'day_end'
    ];
}
