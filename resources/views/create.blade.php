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
        <h1 class="title"> Create a new score</h1>
        <form action="/posts" method="POST">
            @csrf
            <div class='song_imformation'>
                <h2>Song title</h2>
                <input type="text" name="song" placeholder="song title" value="{{ old('song') }}"/>
                <p class="song_imformation__error" style="color:red">{{ $errors->first('song') }}</p>
                <h2>Artist name</h2>
                <input type="text" name="artist" placeholder="artist name" value="{{ old('artist') }}"/>
                <p class="song_imformation__error" style="color:red">{{ $errors->first('artist') }}</p>
            </div>
            <div class='score'>
                <h2>Score</h2>
                <textarea name="post" placeholder="score">{{ old('post') }}</textarea>
                <p class="score__error" style="color:red">{{ $errors->first('post') }}</p>
            </div>
            <input type="submit" value="保存" />
        </form>
        <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>
