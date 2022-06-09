<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use SoftDeletes;
    
    public $fillable = [
        'score',
        'song_id',
        'artist_id'
        ];
    
    
    public function getNewByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('artist')->orderBy('updated_at', 'DESC')->limit($limit_count)->get(); 
    }
    
     public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function artist()
    {
        return $this->belongsTo('App\Artist');
    }
    
    public function song()
    {
        return $this->belongsTo('App\Song');
    }
    
  
}
