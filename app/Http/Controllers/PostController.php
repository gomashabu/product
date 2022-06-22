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
//use GuzzleHttp\Client;

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
        // ユーザー一覧をページネートで取得
        // $users = User::paginate(20);
        
        // 検索フォームで入力された値を取得する
        $search = $request->input('search');

        // クエリビルダ
        $query = $song->get();

       // もし検索フォームにキーワードが入力されたら
        if ($search) {

            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');

            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            // \sは一文字以上の空白　[]はカッコ内の任意の一文字と一致するもの　＋は直前の表現を一文字以上繰り返す
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value) {
                $query->where('title', 'like', '%'.$value.'%');
            }
            
        //上記で取得した$queryをページネートにし、変数$usersに代入    
        $users = $query->paginate(20);
        }

        // ビューにusersとsearchを変数として渡す
        return view('searchResults')
            ->with([
                'users' => $users,
                'search' => $search,
            ]);
            
        // return view('searchResults')->with([
        //     'posts' => $post->getNewByLimit(), 
        //     'artists' => $artist->get(), 
        //     'songs' => $song->get(), 
        //     ]);
    }
}
