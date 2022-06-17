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
        <div class='search'>
            <p>search</p>
        </div>
        @if (Auth::check())
        <div class="AuthOnly">
            <p class="create">[<a href='/posts/create'>create</a>]</p>
            <p class="mysongs">[<a href='/posts/mysongs'>my songs</a>]</p>
            <h8>{{Auth::user()->name}}</h8>
        </div>
        @endif
        <div class='NewSong'>
            @foreach ($posts as $post)
                <div class='TopNewPost'>
                    <a href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class='artist'>- {{ $post->artist->name }}</p>
                    <h8 class='user'>{{ $post->user->name }}</h8>
                    <br><br><br>
                </div>
            @endforeach
        </div>
    </body>
    @endsection
</html>
