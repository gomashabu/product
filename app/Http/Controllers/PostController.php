<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Artist;
use App\Song;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\PostTraits;

class PostController extends Controller
{
    use PostTraits;
    
    public function top(Post $post, Artist $artist, Song $song)
    {
        return view('top')->with([
            'posts' => $post->getNewByLimit(), 
            'artists' => $artist->get(), 
            'songs' => $song->get(), 
            ]);
    }
    
    public function mysongs(Post $post, Artist $artist, Song $song)
    {
        return view('mysongs')->with(['posts' => $post->getMySongByLimit(), 'artists' => $artist->get(), 'songs' => $song->get()]);
    }
    
    public function show(Post $post, Artist $artist, Song $song)
    {
        $id = Auth::id();
        return view('show')->with(['post' => $post, 'artist' => $artist, 'song' => $song, 'id' => $id]);
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
        $user_id = Auth::id();
        $IdInf = $this->GetIdIfExists($request, $post, $artist, $song);
       
        $this->storeOrUpdate($input, $IdInf, $post, $artist, $song, $user_id);
        
        return redirect('/posts/' . $post->id);
    }
    
    public function edit(Post $post, Artist $artist, Song $song)
    {
        return view('edit')->with(['post' => $post, 'artist' => $artist, 'song' => $song]);
    }
    
    public function update(PostRequest $request, Post $post, Artist $artist, Song $song)
    {
        $input = $request->input();
        $user_id = Auth::id();
        $IdInf = $this->GetIdIfExists($request, $post, $artist, $song);
       
        $this->storeOrUpdate($input, $IdInf, $post, $artist, $song, $user_id);
       
        return redirect('/posts/' . $post->id);
    }
    
    public function delete(Post $post, Artist $artist, Song $song)
    {    
        $this->deletePosts($post, $artist, $song);
        return redirect('/');
    }
    
    public function search(Post $post, Artist $artist, Song $song, Request $request)
    {
        // 検索フォームで入力された値を取得する
        $search = $request->input();
        //検索結果の[song.id, artist_id]の配列
        $searched_ids = $this->searchResultsWithSongAndArtist($search, $song, $artist);
        
        return view('searchResults')
            ->with([
                'posts' => $post->whereIn('song_id', $searched_ids['song'])->orWhere(function($query) use($searched_ids){
                return $query->whereIn('artist_id', $searched_ids['artist']);
                })->get(),
                'songs' => $song->get(),
                'artists' => $artist->get(),
                'search' => $search,
            ]);
    }
}