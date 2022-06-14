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
        <form action="/posts" method="POST">
            @csrf
            <div class='song_imformation'>
                <input type="text" name="song" placeholder="song title" />
                <input type="text" name="artist" placeholder="artist name" />
            </div>
            <div class='score'>
                <textarea name="post" placeholder="score"></textarea>
            </div>
            <input type="submit" value="保存" />
        </form>
        <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>
