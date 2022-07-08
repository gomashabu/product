@extends('layouts.app')
@section('content')
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
        <h6 class='user'>{{ $post->user->name }}</h6>
        <br>
    <div id='divSelect'>
        <p>曲のキー</p>
    </div>
        <br><br>
        <p id = "showChordsWithLyrics"></p>
    </div>
    <div>
        <a href="/">Back</a>
    </div>
    <span>
        <!--画像埋め込み
        <img src="{{asset('img/nicebutton.png')}}" width="30px"> -->
         
        <!-- もし$niceがあれば＝ユーザーが「いいね」をしていたら -->
        @if($like)
        <!-- 「いいね」取消用ボタンを表示 -->
        	<a href="{{ route('unlike', $post) }}" class="btn btn-success btn-sm">
        		like
        		<!-- 「いいね」の数を表示 -->
        		<span class="badge">
        			{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }}
        	    </span>
        	</a>
        	
        @else
        <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
        	<a href="{{ route('like', $post) }}" class="btn btn-secondary btn-sm">
        		like
        		<!-- 「いいね」の数を表示 -->
        	    <span class="badge">
            			{{ $like_count->where('id', $post->id)->pluck('likes_count')[0] }}
            	</span>
        	</a>
        @endif
    </span>
<script defer>
    const postScore = `<?php echo $post->score; ?>`;
    function transposeSong(degree){
        var getChords = /\[(.*?)\]/g; 
        var getChordArray;
        var chordArray1 = [];
        var chordArray2 = [];
        while(getChordArray = getChords.exec(postScore)) {
            chordArray1.push(getChordArray[0]);
            chordArray2.push(getChordArray[1]);
        }
        
        function transposeChord(Chord, degree){
            const chord = new ChordSheetJS.parseChord(Chord);
            const chord2 = chord.transpose(degree);
            return(chord2.toString());
        }
        var chordsChangedScore = postScore;
        for (i = 0; i < chordArray1.length; i++) {
        chordsChangedScore = chordsChangedScore.replace(chordArray1[i], '[' + transposeChord(chordArray2[i], degree) + ']');
        }
        return(chordsChangedScore);
    }
    
    function displayScore(degree){
        const chordSheet = `
            {title: <?php echo $post->song->title; ?>}
            {subtitle:}
            {Chorus}
    
            `.substring(1) + transposeSong(degree);
        const parser = new ChordSheetJS.ChordProParser();
        const song = parser.parse(chordSheet);
        const formatter = new ChordSheetJS.HtmlTableFormatter();
        const disp = formatter.format(song);
        console.log(disp);
        var showChords = document.getElementById('showChordsWithLyrics');
            showChordsWithLyrics.innerHTML = disp;
    }
    
    window.onload = function(){
        displayScore(0);
        
        var Element = document.getElementById("divSelect");
        var select = document.createElement("select");
            select.id = "select";
            select.setAttribute('onchange', "displayScore(select.value)");
        Element.appendChild(select);
        for (var i = -6; i<= 6; i++) {
          var option = document.createElement("option");
          option.value = i;
          option.innerText = i;
          select.appendChild(option);
        }
        var select = document.getElementById("select");
            select.options[6].selected = true;
    }
</script>
<script  type="module" src="{{ asset('js/show.js') }}" defer></script>
@endsection
