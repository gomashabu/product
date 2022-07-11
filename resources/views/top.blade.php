<!DOCTYPE html>
@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <div class='search'>
        <form action="/search" method="GET">
            <h3>song title</h3>
            <input type="text" name="song" placeholder="Enter song name" value="@if (isset($song_keyword)) {{ $song_keyword }} @endif">
            <br>
            <h3>artist name</h3>
            <input type="text" name="artist" placeholder="Enter artist name" value="@if (isset($artist_keyword)) {{ $artist_keyword }} @endif">
            <br>
            <input type="submit" value="検索">
        </form>
   </div>
   <br><br>
    @if (Auth::check())
        <div class="AuthOnly">
            <p class="create">[<a href='/posts/create'>create</a>]</p>
            <p class="mysongs">[<a href='/posts/mysongs'>my songs</a>]</p>
            <h8>{{Auth::user()->name}}</h8>
        </div>
    @endif
    <br><br>
    <div class='NewSong'>
        <h3>New songs</h3>
        @foreach ($posts as $post)
            <div class='TopNewPost'>
                <a href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                <p class='artist'>- {{ $post->artist->name }}</p>
                <p class='scoretype'>scoretype : {{ $post->score_type }}</p>
                <p class="badge">like{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }}</p>
                <h8 class='user'>{{ $post->user->name }}</h8>
                <br><br><br>
            </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
@endsection
