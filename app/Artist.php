<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    public function post()
    {
        return $this->hasMany('App\Post');
    }
    public function song()
    {
        return $this->hasMany('App\Song');
    }
}
