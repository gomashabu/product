<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Artist;
use App\Song;

trait PostTraits {
    public function GetIdIfExists($request, $post, $artist, $song) {
        //$artist_names returns the artist-names matching with the song  title input if exists.
        //$artist_id_for_title returns the artist-id matching with the song and artist input if exists.
        $artist_names = $song->song_with_artists_check($request['song']);
        $artist_id_for_title = $artist->song_check_by_artists($artist_names, $request['artist']);
        $song_id = $song->song_id($artist_id_for_title, $request['song']);
        //$artist_names returns the artist-id matching with the artist name input if exists.
        $artist_id = $artist->artist_check($request['artist']);
        
        $IdInf =[
           'artist_names' => $artist_names,
           'artist_id_for_title' => $artist_id_for_title,
           'song_id' => $song_id,
           'artist_id' => $artist_id
           ];
           
        
        return $IdInf;
    }
    

    public function deletePosts(Post $post, Artist $artist, Song $song)
    {
        $request = [
            'song' => $post->song->title,
            'artist' => $post->artist->name
            ];
        $post->delete();
        
        $IdInf = $this->IdGetIfExists($request, $post, $artist, $song);
       
        $song_should_be_deleted = $post->song_should_be_deleted($IdInf['song_id']);
        if($song_should_be_deleted == 'yes'){
            $song->where('id', $IdInf['song_id'])->delete();
        }
        
        $artist_should_be_deleted = $post->artist_should_be_deleted($IdInf['artist_id']);
        if($artist_should_be_deleted == 'yes'){
            $artist->where('id', $IdInf['artist_id'])->delete();
        }
    }
    
    public function storeOrUpdate($input, $IdInf, $post, $artist, $song, $user_id)
    {
        if($IdInf['artist_id'] == null){//全保存
            $artist->fill(['name'=>$input['artist']])->save();
            $song->fill(['title'=>$input['song'],
                         'artist_id'=>$artist['id']])->save();
            $post->fill(['score'=>$input['post'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$artist['id'],
                         'user_id'=>$user_id])->save();
        }elseif($IdInf['artist_id_for_title'] == null){//song, post保存
            $song->fill(['title'=>$input['song'],
                         'artist_id'=>$IdInf['artist_id']])->save();
            $post->fill(['score'=>$input['post'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$IdInf['artist_id'],
                         'user_id'=>$user_id])->save();
        }else{//post保存
            $post->fill(['score'=>$input['post'],
                         'song_id'=>$IdInf['song_id'],
                         'artist_id'=>$IdInf['artist_id'],
                         'user_id'=>$user_id])->save();
        }
    }
}

