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
        //$artist_id returns the artist-id matching with the artist name input if exists.
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
        
        $IdInf = $this->GetIdIfExists($request, $post, $artist, $song);
       
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
            $post->fill(['score_type'=>$input['score_type'],
                         'lyrics_with_chords'=>$input['lyrics_with_chords'],
                         'flat_score'=>$input['flat_score'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$artist['id'],
                         'user_id'=>$user_id,
                         'key' =>$input['key']])->save();
        }elseif($IdInf['artist_id_for_title'] == null){//song, post保存
            $song->fill(['title'=>$input['song'],
                         'artist_id'=>$IdInf['artist_id']])->save();
            $post->fill(['score_type'=>$input['score_type'],
                         'lyrics_with_chords'=>$input['lyrics_with_chords'],
                         'flat_score'=>$input['flat_score'],
                         'song_id'=>$song['id'],
                         'artist_id'=>$IdInf['artist_id'],
                         'user_id'=>$user_id,
                         'key' =>$input['key']])->save();
        }else{//post保存
            $post->fill(['score_type'=>$input['score_type'],
                         'lyrics_with_chords'=>$input['lyrics_with_chords'],
                         'flat_score'=>$input['flat_score'],
                         'song_id'=>$IdInf['song_id'],
                         'artist_id'=>$IdInf['artist_id'],
                         'user_id'=>$user_id,
                         'key' =>$input['key']])->save();
        }
    }
    
    public function wordArraySearched($search)
    {
        // 全角スペースを半角に変換
        $space_conversion = mb_convert_kana($search, 's');
        // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
        // \sは一文字以上の空白　[]はカッコ内の任意の一文字と一致するもの　＋は直前の表現を一文字以上繰り返す
        $word_array_searched = preg_split('/[\s,]+/', $space_conversion, -1, PREG_SPLIT_NO_EMPTY);

        return  $word_array_searched;
    }
    
    public function searchIds($q, $wordArraySearched, $column)
    {
        $query = $q::query();
        
        foreach($wordArraySearched as $value) {
            $query->where($column, 'like', '%'.$value.'%');
        }
        
        $searchedIds = $query->pluck('id');
        
        return $searchedIds;
        
    }
    
    public function searchResultsWithSongAndArtist($search, $song, $artist)
    {
        $searched_ids = [
            'song' => [],
            'artist' => []
            ];
        $search_result_song_ids = [];
        
        
        if ($search['song']) {
            //検索キーワードを整形して、空白で区切られたキーワードの配列に
            $word_array_searched_song = $this->wordArraySearched($search['song']);
            //全キーワードと曲名が部分一致するSongのId
            $searched_ids['song'] = $this->searchIds($song, $word_array_searched_song, 'title')->all();
            
        }
        
        if($search['artist']){
            $word_array_searched_artist = $this->wordArraySearched($search['artist']);
            $searched_ids['artist'] = $this->searchIds($artist, $word_array_searched_artist, 'name')->all();
        }
        
        if($search['artist'] && $search['song']){
            foreach($searched_ids['song'] as $value){
                //検索した1曲のレコード[id, artist_id]
                $artist_ids_by_searched_songs = $song->where('id', $value)->pluck('id', 'artist_id')->all();
                //song名で検索した曲名の一つと検索したartist名が一致する配列[song.id, artist_id]
                $search_result_song_id = array_intersect($artist_ids_by_searched_songs, $searched_ids['artist']);
                //songとartistの両方のキーワードがマッチした配列[song.id, artist_id]
                $search_result_song_ids = $search_result_song_ids + $search_result_song_id;
            }
            $searched_ids['song'] = array_keys($search_result_song_ids);
            $searched_ids['artist'] = [];
        }
        
        return $searched_ids;
    }
}

