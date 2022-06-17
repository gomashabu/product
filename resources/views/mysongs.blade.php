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
        <div class="AuthOnly">
            <p class="create">[<a href='/posts/create'>create</a>]</p>
            <h8>{{ Auth::user()->name }}</h8>
        </div>
        <div class='MySongs'>
            @foreach ($posts as $post)
                <div class='MySongs'>
                    <a href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class='artist'>- {{ $post->artist->name }}</p>
                    <h8 class='user'>{{ $post->user->name }}</h8>
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
    </body>
    @endsection
</html>
