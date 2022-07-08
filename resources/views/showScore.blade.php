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
    <iframe src="https://flat.io/embed/62ad7723aa96a10013152fe7?_l=true&sharingKey=ed9970f42ffd7c64e2c85809e001408b3b30f2efba2fedbbb492ed6fe02e6fbcb33c4cddc816e87165f8184d838a89027d850e22ab852f0a8ef33e699065723b" height="450" width="750" frameBorder="0" allowfullscreen></iframe>
<div style="font-size: 11px; color: #3981FF;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Inter, Helvetica Neue, Helvetica, Arial, sans-serif,sans-serif;margin-top: 4px">View on <a href="https://flat.io" target="_blank" style="color: #3981FF; text-decoration: none;" title="Music notation software">Flat</a>: <a href="https://flat.io/score/62ad7723aa96a10013152fe7?sharingKey=ed9970f42ffd7c64e2c85809e001408b3b30f2efba2fedbbb492ed6fe02e6fbcb33c4cddc816e87165f8184d838a89027d850e22ab852f0a8ef33e699065723b" target="_blank" style="color: #3981FF; text-decoration: none;">Son tutta duolo</a></div>
</div>
<div>
    <a href="/">Back</a>
</div>
@endsection
