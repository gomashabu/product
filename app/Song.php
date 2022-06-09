<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function post()
    {
        return $this->hasMany('App\Post');
    }
    public function artist()
    {
        return $this->belongsTo('App\Artist');
    }
}
