@extends('layouts.app')　　

@section('content')
    <h1 class="title"> Create a new score</h1>
    <form action="/posts" method="POST">
        @csrf
        <div class='song_imformation'>
            <h3>Song title</h3>
            <input type="text" name="song" placeholder="song title" value="{{ old('song') }}"/>
            <p class="song_imformation__error" style="color:red">{{ $errors->first('song') }}</p>
            <h3>Artist name</h3>
            <input type="text" name="artist" placeholder="artist name" value="{{ old('artist') }}"/>
            <p class="song_imformation__error" style="color:red">{{ $errors->first('artist') }}</p>
        </div>
        <div class="score_type">
            <div class="form-check form-check-inline">
                <input type="radio" name="score_type" class="form-check-input" id="release1" value="Lyrics with chords"{{ old ('score_type') == 'Lyrics with chords' ? 'checked' : '' }} onclick="formSwitch()" checked>
                <label for="release1" class="postcheck-label">lyrics with chords</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="score_type" class="form-check-input" id="release2" value="Flat score"{{ old ('score_type') == 'Flat score' ? 'checked' : '' }}　onclick="formSwitch()">
                <label for="release2" class="postcheck-label">flat score</label>
            </div>
            </label>
        </div>
        <div class='score'>
            <div class = 'lyricsWithChord'>
                <h3 id='LyricsInputTitle' >Lyrics with chord</h3>
                <textarea class='textarea'  id='lyricsInput' name="lyrics_with_chords" placeholder="Enter your score" rows="30" cols="60" >{{ old('post') }}</textarea>
                <p class="score__error" style="color:red">{{ $errors->first('lyrics_with_chords') }}</p>
            </div>
        </div>
        <div class='FlatScore'>
            <h3>FlatScore</h3>
            <textarea class='textarea' name="flat_score" placeholder="Enter your Flat Score" rows="10" cols="60">{{ old('post') }}</textarea>
            <p class="score__error" style="color:red">{{ $errors->first('lyrics_with_chords') }}</p>
        </div>
        <input type="submit" value="保存" />
    </form>
    <div class="back">[<a href="/">back</a>]</div>
<script src="{{ asset('js/formswitch.js') }}" defer></script>
@endsection