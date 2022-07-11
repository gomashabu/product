@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
@if ($id == $post->user->id)
    <div class="edit">
        <p class="edit">[<a href="/posts/{{ $post->id }}/edit">edit</a>]</p>
        <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit">delete</button> 
        </form>
    </div>
@endif
<div class='post'>
    <p>{{ $post->song->title }}</p>
    <p class='artist'>- {{ $post->artist->name }}</p>
    <h8 class='user'>{{ $post->user->name }}</h8>
    <br><br><br>
    <div id="flatScore"></div>
<div>
    <a href="/">Back</a>
</div>
<script>

    const flatApi = `<?php echo $post->flat_score; ?>`
    var flatScore = document.getElementById('flatScore');
    flatScore.innerHTML = flatApi;
</script>
@endsection
