<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Artist;
use App\Song;
use App\Like;
use App\Comment;
use App\Claim;
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
        $like_count = Post::withCount('likes')->get();
        return view('top')->with([
            'NewPosts' => $post->getPaginateByLimit(),
            'TopPosts' => $post->getPaginateTopByLimit(),
            'artists' => $artist->get(), 
            'songs' => $song->get(), 
            'like_count' => $like_count
            ]);
    }
    
    public function mysongs(Post $post, Artist $artist, Song $song)
    {
        // $like=Like::where('post_id', $post->id)->where('user_id', $id)->first(); 
        $like_count = Post::withCount('likes')->get();
        return view('mysongs')->with(['posts' => $post->getMySongByLimit(), 'artists' => $artist->get(), 'songs' => $song->get(), 'like_count' => $like_count]);
    }
    
    public function showLyricsOrFlat(Post $post, Artist $artist, Song $song, Comment $comment, Claim $claim)
    {
        $id = Auth::id();
        $like=Like::where('post_id', $post->id)->where('user_id', $id)->first();
        $like_count = Post::withCount('likes')->get();
        if($post->score_type == 'Lyrics with chords'){
            
            return view('show')->with([
                    'post' => $post, 
                    'artist' => $artist, 
                    'song' => $song, 
                    'id' => $id, 
                    'like' => $like, 
                    'like_count' => $like_count, 
                    'comments' => $comment->getPaginateByLimit($post->id), 
                    'claimsByRows'=> $claim->getClaimsByRows($post->id),
                    'claimRows' =>$claim->getClaimsRows($post->id),
            ]);
        }elseif($post->score_type == 'Flat score'){
            return view('showFlat')->with([
                    'post' => $post, 
                    'artist' => $artist, 
                    'song' => $song, 
                    'id' => $id, 
                    'like' => $like,
                    'like_count' => $like_count, 
                    'comments' => $comment->getPaginateByLimit($post->id)
            ]);
        }
    }
    
    public function claim(Post $post, Artist $artist, Song $song, Claim $claim)
    {
        $id = Auth::id();
        return view('claim')->with([
                    'post' => $post, 
                    'artist' => $artist, 
                    'song' => $song, 
                    'id' => $id, 
                    'claimsByRows'=> $claim->getClaimsByRows($post->id),
                    'claimRows' =>$claim->getClaimsRows($post->id),
                    'claimOfThisUser' =>$claim->getClaimOfThisUser($post->id, $id),
            ]);
    }

    public function create()
    {
        return view('create');
    }
    
    public function storeComment(
        Request $request,
        Post $post,
        Comment $comment)
    {  
        $input = $request['comment'];
        $user_id = Auth::id();
        $comment->fill(['comment'=>$input,
                        'post_id'=>$post->id,
                        'user_id'=> $user_id])->save();
        return redirect('/posts/' . $post->id);
    }
    
    public function storeClaim(
        Request $request,
        Post $post,
        Claim $claim)
    {  
        $input = $request->input();
        $user_id = Auth::id();
        $claim->fill(['claim'=>$input['claim'],
                      'row_number'=>$input['row_number'],
                      'post_id'=>$post->id,
                      'user_id'=> $user_id])->save();
        return redirect('/posts/'. $post->id .'/claim');
    }
    
    public function updateClaim(
        Request $request,
        Post $post,
        Claim $claim)
    {    
        $input = $request->input();
        $user_id = Auth::id();
        $claim->fill(['claim'=>$input['claim'],
                      'row_number'=>$input['row_number'],
                      'post_id'=>$post->id,
                      'user_id'=> $user_id])->save();
        return redirect('/posts/'. $post->id .'/claim');
    }
    
    public function edit(Post $post, Artist $artist, Song $song)
    {
        return view('edit')->with(['post' => $post, 'artist' => $artist, 'song' => $song]);
    }
    
    public function storeUpdate(
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
    
    public function delete(Post $post, Artist $artist, Song $song)
    {    
        $this->deletePosts($post, $artist, $song);
        return redirect('/');
    }
    
    public function search(Post $post, Artist $artist, Song $song, Request $request, int $limit_count = 5)
    {
        // 検索フォームで入力された値を取得する
        $search = $request->input();
        //検索結果の[song.id, artist_id]の配列
        $searched_ids = $this->searchResultsWithSongAndArtist($search, $song, $artist);
        $like_count = Post::withCount('likes')->get();
        
        return view('searchResults')
            ->with([
                'posts' => $post->search($searched_ids),
                'songs' => $song->get(),
                'artists' => $artist->get(),
                'search' => $search,
                'like_count' => $like_count
            ]);
    }
    
    public function like(Post $post, Request $request, Like $like){
        $like->post_id=$post->id;
        $like->user_id=Auth::user()->id;
        $like->save();
        return back();
    }
    
    public function unlike(Post $post, Request $request, Like $like){
        $user=Auth::user()->id;
        $like=Like::where('post_id', $post->id)->where('user_id', $user)->first();
        $like->delete();
        return back();
    }
}