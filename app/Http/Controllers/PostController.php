<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Artist;
use App\Song;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    public function home(Post $post, Artist $artist, Song $song)
    {
        return view('home')->with(['posts' => $post->getNewByLimit(), 'artists' => $artist->get(), 'songs' => $song->get()]);
    }
    
    public function show(Post $post, Artist $artist, Song $song)
    {
        return view('show')->with(['post' => $post, 'artist' => $artist, 'song' => $song]);
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function store(
        PostRequest $request,
        Post $post,
        Song $song,
        Artist $artist)
    {  
        $input = $request->input();
        //$artist_names returns the artist-names matching with the song  title input if exists.
        //$artist_id_for_title returns the artist-id matching with the song and artist input if exists.
        $artist_names = $song->song_with_artists_check($request['song']);
        $artist_id_for_title = $artist->song_check_by_artists($artist_names, $request['artist']);
        $song_id = $song->song_id($artist_id_for_title, $request['song']);
        
        //$artist_names returns the artist-id matching with the artist name input if exists.
        $artist_id = $artist->artist_check($request['artist']);
       
       //以下データ保存用関数
        if($artist_id == null){//全保存
            $artist->fill(['name'=>$request['artist']])->save();
            $song->fill(['title'=>$request['song'],
                         'artist_id'=>$artist['id']])->save();
            $post->fill(['score'=>$request['post'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$artist['id']])->save();
        }elseif($artist_id_for_title == null){//song, post保存
            $song->fill(['title'=>$request['song'],
                         'artist_id'=>$artist_id])->save();
            $post->fill(['score'=>$request['post'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$artist_id])->save();
        }else{//post保存
            $post->fill(['score'=>$request['post'],
                         'song_id'=>$song_id,
                         'artist_id'=>$artist_id])->save();
        }
        
        return redirect('/posts/' . $post->id);
    }
    
    public function edit(Post $post, Artist $artist, Song $song)
    {
        return view('edit')->with(['post' => $post, 'artist' => $artist, 'song' => $song]);
    }
    
    public function update(PostRequest $request, Post $post, Artist $artist, Song $song)
    {
        $input = $request->input();
        //$artist_names returns the artist-names matching with the song  title input if exists.
        //$artist_id_for_title returns the artist-id matching with the song and artist input if exists.
        $artist_names = $song->song_with_artists_check($request['song']);
        $artist_id_for_title = $artist->song_check_by_artists($artist_names, $request['artist']);
        $song_id = $song->song_id($artist_id_for_title, $request['song']);
        
        //$artist_names returns the artist-id matching with the artist name input if exists.
        $artist_id = $artist->artist_check($request['artist']);
       
       //以下データ保存用関数
        if($artist_id == null){//全保存
            $artist->fill(['name'=>$request['artist']])->save();
            $song->fill(['title'=>$request['song'],
                         'artist_id'=>$artist['id']])->save();
            $post->fill(['score'=>$request['post'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$artist['id']])->save();
        }elseif($artist_id_for_title == null){//song, post保存
            $song->fill(['title'=>$request['song'],
                         'artist_id'=>$artist_id])->save();
            $post->fill(['score'=>$request['post'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$artist_id])->save();
        }else{//post保存
            $post->fill(['score'=>$request['post'],
                         'song_id'=>$song_id,
                         'artist_id'=>$artist_id])->save();
        }
        
        return redirect('/posts/' . $post->id);
    }
}
