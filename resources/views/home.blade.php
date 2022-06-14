<!DOCTYPE html>
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
        <div class='NewSong'>
            [<a href='/posts/create'>create</a>]
            @foreach ($posts as $post)
                <div class='TopNewPost'>
                    <a href="/posts/{{ $post->id }}">{{ $post->song->title }}</a>
                    <p class='artist'>- {{ $post->artist->name }}</p>
                    <h8 class='user'>{{ $post->user_id }}</h8>
                </div>
            @endforeach
        </div>
    </body>
</html>
