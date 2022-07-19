@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('css')
    {{ asset('css/myPage.css') }}
@endsection

@section('content')
    <div class="forLoggedIn">
        <div class="right">
            <p>{{ Auth::user()->name }}</p>
            <p class="create">[<a href='/posts/create'>create</a>]</p>
        </div>
    </div>
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
    <div class="rankings">
        <div class = "ranking">
            <h3 class="rankTitle">My songs</h3>
            @foreach ($posts as $post_key => $post)
                <div class='TopNewPosts'>
                    <p class="songInf">{{$posts->firstItem()+$post_key}}.</p>
                    <a class="songInf" href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class="songInf">- {{ $post->artist->name }}</p>
                    <br>
                    <p class="songInf space">scoretype : {{ $post->score_type }}</p>
                    <br>
                    <p class="songInf space">{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }} like(s)</p>
                    <br><br>
                </div>
            @endforeach
        </div>
        <div class = "ranking">
            <h3 class="rankTitle">Song you liked</h3>
            @foreach ($likedPosts as $post_key => $post)
                <div class='songYouLiked'>
                    <p class="songInf">{{$posts->firstItem()+$post_key}}.</p>
                    <a class="songInf" href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class="songInf">- {{ $post->artist->name }}</p>
                    <br>
                    <p class="songInf space">scoretype : {{ $post->score_type }}</p>
                    <br>
                    <p class="songInf space">{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }} like(s)</p>
                    <br><br>
                </div>
            @endforeach
        </div>
        <div class = "ranking">
            <h3 class="rankTitle">Song you commented</h3>
            @foreach ($commentedPosts as $post_key => $post)
                <div class='songYouLiked'>
                    <p class="songInf">{{ $posts->firstItem()+$post_key}}.</p>
                    <p class="songInf">{{ $post->comments->where('user_id', Auth::user()->id)->pluck('comment') }}</p>
                    <br>
                    <div class="postInfo">
                        <a　class="songInf" href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                        <p class="songInf">- {{ $post->artist->name }}</p>
                        <br>
                        <p class="songInf">scoretype : {{ $post->score_type }}</p>
                        <br>
                        <p class="songInf">{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }} like(s)</p>
                    </div>
                    <br><br>
                </div>
            @endforeach
        </div>
    </div>
    <div class="outOfFooter">
        <div class="footer">
            <a href="/">Back</a>
        </div>
    </div>
     <script>
        function deletePost(){
            if(confirm('削除すると復元できません。\n本当に削除しますか？')){
                document.getElementById("form_delete").submit();
            }
        }
    </script>
@endsection
