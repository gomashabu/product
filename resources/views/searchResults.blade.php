@extends('layouts.app')　　　

@section('css')
    {{ asset('css/searchResults.css') }}
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
                <input type="text" class = "searchBox" name="song" placeholder="Enter song name" value="@if (isset($search['song'])) {{ $search['song'] }} @endif">
            </div>
            <br>
            <div class = "artist">
                <h3 class = "title">Artist name</h3>
                <input type="text" class = "searchBox" name="artist" placeholder="Enter artist name" value="@if (isset($search['artist'])) {{ $search['artist'] }} @endif">
            </div>
            <input id="searchButton" type="submit" value="検索">
        </form>
    </div>
    <br><br><br>
    <div class = "songsSearched">
        <div class = "ranking">
            @if(isset($search))
            <h3 class="rankTitle">Search results</h3>
            @else
            <h3 class="rankTitle">{{ $posts[0] }}</h3>
            @endif
            @foreach ($posts[1] as $post_key => $post)
                <div class='post'>
                    <p class="songInf number">{{$posts[1]->firstItem()+$post_key}}.</p>
                    <a class="songInf postSongTitle" href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class="songInf hyphen">-</p>
                    <p class="songInf"><a href="/ranking/songsOfAnArtist/{{ $post->artist->id }}">{{ $post->artist->name }}</a></p>
                    <br>
                    <p class="songInf space" id="scoreType">scoretype : {{ $post->score_type }}</p>
                    <p class="songInf space">{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }} like(s)</p>
                </div>
            @endforeach
        </div>
        <div class='paginate'>{{ $posts[1]->links() }}</div>
    </div>
    <div class="outOfFooter">
        <div class="footer">
            <a href="/">Back</a>
        </div>
    </div>
@endsection