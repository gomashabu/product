<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;


class Post extends Model
{
    use SoftDeletes;
    
    public $fillable = [
        'score_type',
        'lyrics_with_chords',
        'flat_score',
        'song_id',
        'artist_id',
        'user_id',
        'key',
        ];
    
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('artist')->orderBy('updated_at', 'DESC')->paginate($limit_count); 
    }
    
    public function getPaginateTopByLimit(int $limit_count = 5)
    {
        // likesの個数で降順に並べたあと、limitで件数制限をかける
        return $this::withCount('likes')->orderBy('likes_count', 'DESC')->paginate($limit_count); 
    }
    
    public function getMySongByLimit(int $limit_count = 5)
    {
        $auths = Auth::id();
        return $this::with('artist')->where('user_id', $auths)->orderBy('updated_at', 'DESC')->paginate($limit_count); 
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
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
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
    
    public function search($searched_ids, int $limit_count = 10){
        $posts = $this::withCount('likes')->whereIn('song_id', $searched_ids['song'])->orWhere(function($query) use($searched_ids){
                    return $query->whereIn('artist_id', $searched_ids['artist']);
                })->orderBy('likes_count', 'DESC')->paginate($limit_count);
        return $posts;
    }
  
}

