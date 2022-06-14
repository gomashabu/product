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
        [<a href='/posts/create'>create</a>]
        <div class='post'>
            <p>{{ $post->song->title }}</p>
            <p class='artist'>- {{ $post->artist->name }}</p>
            <h8 class='user'>{{ $post->user_id }}</h8>
            <p>{{ $post->score }}</p>
        </div>
        <div>
            <a href="/">Back</a>
        </div>
    </body>
</html>