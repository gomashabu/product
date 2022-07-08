<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Post extends Model
{
    use SoftDeletes;
    
    public $fillable = [
        'score',
        'song_id',
        'artist_id',
        'user_id'
        ];
    
    
    public function getNewByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('artist')->orderBy('updated_at', 'DESC')->limit($limit_count)->get(); 
    }
    
    public function getMySongByLimit(int $limit_count = 10)
    {
        $auths = Auth::id();
        return $this::with('artist')->where('user_id', $auths)->orderBy('updated_at', 'DESC')->limit($limit_count)->get(); 
    }
    
    public function artist()
    {
        return $this->belongsTo('App\Artist');
    }
    
    public function song()
    {
        return $this->belongsTo('App\Song');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    
    public function song_should_be_deleted($query)
    {
        $song_still_exist = $this->where('song_id', $query)->pluck('song_id');
        if(isset($song_still_exist[0])){
            return $song_still_exist[0];
        }
        return 'yes';
    }
    
    public function artist_should_be_deleted($query)
    {
        $artist_still_exist = $this->where('artist_id', $query)->pluck('artist_id');
        if(isset($artist_still_exist[0])){
            return $artist_still_exist[0];
        }
        return 'yes';
    }
  
}

