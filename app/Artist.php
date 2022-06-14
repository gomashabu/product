<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Artist extends Model
{
    protected $fillable = [
        'name'
        ];
        
    public function post()
    {
        return $this->hasMany('App\Post');
    }
    public function song()
    {
        return $this->hasMany('App\Song');
    }
    
    //$query is array. Artist names is included array.
    //$requst is string. $request is sent as the artist name from create.blde.php
    public function song_check_by_artists($query , $request)
    {
       $artist_exist = array_filter($query, function($q) use ($request){
           return $q == $request;
       });
     
        if($artist_exist){
            $artist_id_for_title = $this->where('name', $artist_exist)->pluck('id');
            return $artist_id_for_title[0];
        }
        
        return null;
    }
    
    public function artist_check($query)
    {
        $artist_id = $this->where('name', $query)->pluck('id');
        if(isset($artist_id[0])){
            return $artist_id[0];
        }
        return null;
    }
}