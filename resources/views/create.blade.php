@extends('layouts.app')　　

@section('css')
    {{ asset('css/edit.css') }}
@endsection

@section('content')
    <div class="spaceForNaavBar" style="margin-bottom: 80px;"></div>    
    <h1 class="title"> Create a new score</h1>
    <form action="/posts" method="POST">
        @csrf
        <div class="boforeScore">
            <div class='song_imformation'>
                <div class="text">
                   <h4>Song title</h4>
                   <h4>Artist name</h4>
                </div>
                <div class="inputText">
                    <input type="text" name="song" placeholder="song title" value="{{ old('song') }}"/>
                    <p class="song_imformation__error" style="color:red">{{ $errors->first('song') }}</p>
                    <input type="text" name="artist" placeholder="artist name" value="{{ old('artist') }}"/>
                    <p class="song_imformation__error" style="color:red">{{ $errors->first('artist') }}</p>
                </div>
            </div>    
            <div class="score_type">
                <h4>Score type</h4>
                <div class="form-check form-check-inline">
                    <input type="radio" name="score_type" class="form-check-input" id="release1" value="Lyrics with chords"{{ old ('score_type') == 'Lyrics with chords' ? 'checked' : '' }} onclick="formSwitch()" checked>
                    <label for="release1" class="postcheck-label">lyrics with chords</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="score_type" class="form-check-input" id="release2" value="Flat score"{{ old ('score_type') == 'Flat score' ? 'checked' : '' }} onclick="formSwitch()" >
                    <label for="release2" class="postcheck-label">flat score</label>
                </div>
            </div>
        </div>
        <div class='scores'>
            <div class="score">
                <div class = 'lyricsWithChord'>
                    <div class="scoreTop">
                        <h3 id='LyricsInputTitle' >Lyrics with chord</h3>
                        <h5>key: </h5>
                        <input type="text" name="key" value="{{ old('key') }}" style="display:block">
                    </div>
                    <textarea class='textarea'  id='lyricsInput' name="lyrics_with_chords" placeholder="Enter your score" rows="30" cols="80">{{ old('post') }}</textarea>
                    <p class="score__error" style="color:red">{{ $errors->first('lyrics_with_chords') }}</p>
                </div>
            </div>
            <div class='FlatScore'>
                <div style="margin-top: 25px; padding-bottom: 10px; height: 80px;">
                    <h3>FlatScore</h3>
                </div>
                <textarea class='textarea' name="flat_score" placeholder="Enter your Flat Score" rows="20" cols="80">{{ old('post') }}</textarea>
                <p class="score__error" style="color:red">{{ $errors->first('lyrics_with_chords') }}</p>
            </div>
            <input class="submitButton" type="submit" value="保存" />
        </div>
    </form>
    <div class="footer">
        <div class="back">[<a href="/">back</a>]</div>
    </div>
<script src="{{ asset('js/formswitch.js') }}" defer></script>
@endsection