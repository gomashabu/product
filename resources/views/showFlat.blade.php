@extends('layouts.app')

@section('css')
    {{ asset('css/showFlat.css') }}
@endsection

@section('content')
<div class="spaceForNaavBar" style="margin-bottom: 80px;"></div>
@if ($id == $post->user->id)
    <div class="aboveScore">
        <div class="forPoster">
            <p class="edit">[<a href="/posts/{{ $post->id }}/edit">edit this post</a>]</p>
            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" id="deleteButton">delete this post</button> 
            </form>
        </div>
    </div>
@endif
<div class='postTitle'>
    <h1>{{ $post->song->title }}</h1>
    <h3 id="byBetTitle">by</h3>
    <h2>{{ $post->artist->name }}</h2>
    <br>
    <h6 class="float-right">posted by {{ $post->user->name }}</h6>
</div>
<div class='post'>
    <div id="flatScore"></div>
</div>
<div class="footer">
    <div>
        <a href="/">Back</a>
    </div>
    <span>
        <!--画像埋め込み
        <img src="{{asset('img/nicebutton.png')}}" width="30px"> -->
         
        <!-- もし$niceがあれば＝ユーザーが「いいね」をしていたら -->
        @if($like)
        <!-- 「いいね」取消用ボタンを表示 -->
        	<a href="{{ route('unlike', $post) }}" class="btn btn-success btn-sm">
        		like
        		<!-- 「いいね」の数を表示 -->
        		<span class="badge">
        			{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }}
        	    </span>
        	</a>
        @else
        <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
        	<a href="{{ route('like', $post) }}" class="btn btn-secondary btn-sm">
        		like
        		<!-- 「いいね」の数を表示 -->
        	    <span class="badge">
            			{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }}
            	</span>
        	</a>
        @endif
    </span>
</div>
<div class='comments'>
    <h3>Comments</h3>
    @if (Auth::check())
        <form action="/posts/{{ $post->id }}/comment" method="POST">
            @csrf
            <textarea class='textarea'  id='CommentInput' name="comment" placeholder="Enter your comment" rows="5" cols="50" >{{ old('comment') }}</textarea>
            <input type="submit" value="保存" />
        </form>
    @endif
    @foreach ($comments as $comment)
        <div class='commentList'>
            <p class='comment'>{{ $comment->comment }}</p>
            <p class='user'>- {{ $comment->user->name }}</p>
        </div>
    @endforeach
</div>
<script>

    const flatApi = `<?php echo $post->flat_score; ?>`
    var flatScore = document.getElementById('flatScore');
    flatScore.innerHTML = flatApi;
</script>
@endsection
