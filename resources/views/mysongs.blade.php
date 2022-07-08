@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <div class='search'>
        <p>search</p>
    </div>
    <div class="AuthOnly">
        <p class="create">[<a href='/posts/create'>create</a>]</p>
        <h8>{{ Auth::user()->name }}</h8>
    </div>
    <div class='MySongs'>
        @foreach ($posts as $post)
            <div class='MySongs'>
                <a href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                <p class='artist'>- {{ $post->artist->name }}</p>
                <p class="badge">like{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }}</p>
                <h8 class='user'>{{ $post->user->name }}</h8>
        		<!-- 「いいね」の数を表示 -->
                <form action="/posts/{{ $post->id }}" id="form_delete"  method="post" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <input id="btnDelete" type="button" onclick="deletePost()" value="delete">
                </form>
            </div>
        @endforeach
    </div>
     <script>
        function deletePost(){
            if(confirm('削除すると復元できません。\n本当に削除しますか？')){
                document.getElementById("form_delete").submit();
            }
        }
    </script>
@endsection
