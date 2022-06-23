<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\PostTraits;

class Song extends Model
{
    use SoftDeletes;
    
     
    public $fillable = [
        'title',
        'artist_id'
        ];
        
    public function post()
    {
        return $this->hasMany('App\Post');
    }
    public function artist()
    {
        return $this->belongsTo('App\Artist');
    }
    
    public function song_with_artists_check($query)
    {
        $song_exist = $this->where('title', $query)->get();
        $artist_names = [];
        
        if($song_exist){
            foreach($song_exist as $song){
              array_push($artist_names, $song->artist->name);
            }
            return $artist_names;
        }
        return null;
        
    }
    
    public function song_id($query, $query2)
    { 
        if($query){
            $song_id = $this->where('title', $query2)->where('artist_id', $query)->pluck('id');
            return $song_id[0];
        }
    }
}
