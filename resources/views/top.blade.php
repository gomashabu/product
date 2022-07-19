<!DOCTYPE html>
@extends('layouts.app')　

@section('css')
    {{ asset('css/top.css') }}
@endsection

@section('content')
    @if (Auth::check())
        <div class="forLoggedIn">
            <div class="right">
                <p class="create">[<a href='/posts/create'>create</a>]</p>
                <p class="myPage">[<a href='/posts/myPage'>my page</a>]</p>
            </div>
        </div>
    @else
        <div class="spaceForNaavBar" style="margin-bottom: 80px;"></div>
    @endif
    <div class='search'>
        <form action="/search" method="GET" class = "SearchForm">
            <div class = "song">
                <h3 class = "title" style="margin-right: 5px;">Song title</h3>
                <input type="text" class = "searchBox" name="song" placeholder="Enter song name" value="@if (isset($song_keyword)) {{ $song_keyword }} @endif">
            </div>
            <br>
            <div class = "artist">
                <h3 class = "title">Artist name</h3>
                <input type="text" class = "searchBox" name="artist" placeholder="Enter artist name" value="@if (isset($artist_keyword)) {{ $artist_keyword }} @endif">
            </div>
            <input id="searchButton" type="submit" value="検索">
        </form>
   </div>
   <br>
    <br><br>
    <div class="rankings">
        <div class = "ranking">
            <h3 class="rankTitle"><a href="/ranking/topSong/null">Top songs</a></h3>　
            @foreach ($TopPosts as $post_key => $post)
                <div class='TopPosts'>
                    <p class="songInf">{{$TopPosts->firstItem()+$post_key}}.</p>
                    <a class="songInf" href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class="songInf hyphen">-</p>
                    <p class="songInf"><a href="/ranking/songsOfAnArtist/{{ $post->artist->id }}">{{ $post->artist->name }}</a></p>
                    <br>
                    <p class="songInf space">scoretype : {{ $post->score_type }}</p>
                    <br>
                    <p class="songInf space">{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }} like(s)</p>
                    <br><br>
                </div>
            @endforeach
        </div>
        <div class = "ranking">
            <h3 class="rankTitle"><a href="/ranking/newSong/null">New songs</a></h3>
            @foreach ($NewPosts as $post_key => $post)
                <div class='TopNewPosts'>
                    <p class="songInf">{{$NewPosts->firstItem()+$post_key}}.</p>
                    <a class="songInf" href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class="songInf hyphen">-</p>
                    <p class="songInf"><a href="/ranking/songsOfAnArtist/{{ $post->artist->id }}">{{ $post->artist->name }}</a></p>
                    <br>
                    <p class="songInf space">scoretype : {{ $post->score_type }}</p>
                    <br>
                    <p class="songInf space">{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }} like(s)</p>
                    <br><br>
                </div>
            @endforeach
        </div>
    </div>
@endsection
