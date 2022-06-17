<!DOCTYPE html>
@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>chords</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body>
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
            <p>{{ $post->score }}</p>
        </div>
        <div>
            <a href="/">Back</a>
        </div>
    </body>
    @endsection
</html>
