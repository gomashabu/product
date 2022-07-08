@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <h1 class="title">Edit your score</h1>
    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class='song_imformation'>
            <h2>Song title</h2>
            <input type="text" name="song"  value="{{ $post->song->title }}"/>
            <p class="song_imformation__error" style="color:red">{{ $errors->first('song') }}</p>
            <h2>Artist name</h2>
            <input type="text" name="artist" placeholder="artist name" value="{{ $post->artist->name }}"/>
            <p class="song_imformation__error" style="color:red">{{ $errors->first('artist') }}</p>
        </div>
        <div class='score'>
            <h2>Score</h2>
            <textarea name="post" placeholder="score">{{ $post->score }}</textarea>
            <p class="score__error" style="color:red">{{ $errors->first('post') }}</p>
        </div>
        <input type="submit" value="保存" />
    </form>
    <div class="back">[<a href="/">back</a>]</div>
@endsection
