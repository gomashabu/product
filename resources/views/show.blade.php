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
    @if($post->key)
        <div class="chord_type">
            <p>コードタイプ</p>
            <div class="toChordSymbol">
                <input type="radio" name="ChordType" value="symbol" onclick="displayScore('symbol', '0')" checked>
                <label for="release1" class="postcheck-label">Chord Symbols</label>
            </div>
            <div class="toNumeralChord">
                <input type="radio" name="ChordType" value="numeral" onclick="displayScore('numeral', '0')">
                <label for="release2" class="postcheck-label">Numeral Chords</label>
            </div>
        </div>
    @endif
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
    <div class='Comment'>
        <h3>Comment</h3>
        @foreach ($comments as $comment)
            <div class='commentList'>
                <p class='comment'>{{ $comment->comment }}</p>
                <p class='user'>- {{ $comment->user->name }}</p>
                <br><br><br>
            </div>
        @endforeach
    </div>
    <div class='Claim'>
        <h3>Claim</h3>
        @foreach ($claims as $claim)
            <div class='commentList'>
                <p class='comment'>{{ $claim->claim }}</p>
                <p class='user'>- {{ $claim->user->name }}</p>
                <br><br><br>
            </div>
        @endforeach
    </div>
    @if (Auth::check())
        <form action="/posts/{{ $post->id }}/comment" method="POST">
            @csrf
            <h3 id='CommentForm' >Comment form</h3>
            <textarea class='textarea'  id='CommentInput' name="comment" placeholder="Enter your comment" rows="5" cols="30" >{{ old('comment') }}</textarea>
            <input type="submit" value="保存" />
        </form>
    @endif
    <script defer>
        const postScore = `<?php echo $post->lyrics_with_chords; ?>`;
        var key = "{{ $post->key }}";
        
        /* 曲を変更する関数。ifTransoise=1の場合、degreeに応じて転調する。iftranspose=0の場合、degreeに応じてnumeral⇄symbolの変換 */
        function changeSong(degree, ifTranspose){
            /* scoreからコードのみを抽出し、配列にする*/
            var getChords = /\[(.*?)\]/g; 
            var getChordArray;
            var chordArray1 = [];
            var chordArray2 = []; 
            while(getChordArray = getChords.exec(postScore)) {
                chordArray1.push(getChordArray[0]);
                chordArray2.push(getChordArray[1]);
            }
            
            /* 楽譜のコードを変換(転調もしくはnumeral⇄symbol) */
            var chordsChangedScore = postScore;
            if(ifTranspose == "1"){
                for (i = 0; i < chordArray1.length; i++) {
                chordsChangedScore = chordsChangedScore.replace(chordArray1[i], '[' + transposeChord(chordArray2[i], degree) + ']');
                }
            }else if(ifTranspose == "0"){
                    for (i = 0; i < chordArray1.length; i++) {
                        var onChordFirst = /\[(.*?)\//g.exec(chordArray1[i]);
                        var onChordLast = /\/(.*?)\]/g.exec(chordArray1[i]);
                        if(onChordFirst){
                            chordsChangedScore = chordsChangedScore.replace(onChordFirst[0], '[' + numeralFromToSymbol(degree, onChordFirst[1], key) + '/');
                            chordsChangedScore = chordsChangedScore.replace(onChordLast[0], '/' + numeralFromToSymbol(degree, onChordLast[1], key) + ']');
                        }else{
                            chordsChangedScore = chordsChangedScore.replace(chordArray1[i], '[' + numeralFromToSymbol(degree, chordArray2[i], key) + ']');
                        }
                    }
            }
            return(chordsChangedScore);
        }
        
        /*一つのコードを転調の変換*/
        function transposeChord(Chord, degree){
            const chord = new ChordSheetJS.parseChord(Chord);
            const chord2 = chord.transpose(degree);
            return(chord2.toString());
        }
        /*一つのコードをnumeral⇄symbolする*/
        function numeralFromToSymbol(numeralOrSymbol, Chord, key){
            var changedChord;
            if(numeralOrSymbol == "symbol"){
                const numeralChord = new ChordSheetJS.parseChord(Chord);
                const chordSymbol = numeralChord.toChordSymbol(key);
                changedChord = chordSymbol.toString(); 
            }else if(numeralOrSymbol == "numeral"){
                var keySig = /.(.?)/g.exec(Chord)[1];
                var restOfChord = /.(.*)/g.exec(Chord)[1];
                Chord　= /(.?)/g.exec(Chord)[1];
                /* コードの一文字目だけ取得して数字に変換した後、二文字目の調号の分(もしあれば)だけ転調し、それ以降の文字列をくっつける */
                if(restOfChord){
                    if(/.(.*)/g.exec(restOfChord)[1]){
                        if(keySig == "#"){
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            console.log(numeralOrSymbol, Chord, key);
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "1");
                            restOfChord = /.(.*)/g.exec(restOfChord)[1];
                            changedChord = chordBass + restOfChord;
                        }else if(keySig == "b"){
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            console.log(numeralOrSymbol, Chord, key);
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "-1");
                            restOfChord = /.(.*)/g.exec(restOfChord)[1];
                            changedChord = chordBass + restOfChord;
                        }else{
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            const numeralChord = chordSymbol.toNumeral(key);
                            changedChord = numeralChord.toString() + restOfChord;
                        }
                    }else{
                        if(keySig == "#"){
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            console.log(numeralOrSymbol, Chord, key);
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "1");
                            changedChord = chordBass;
                        }else if(keySig == "b"){
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            console.log(numeralOrSymbol, Chord, key);
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "-1");
                            changedChord = chordBass;
                        }else{
                            console.log(Chord);
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            const numeralChord = chordSymbol.toNumeral(key);
                            console.log(numeralChord.toString());
                            chordChanged = numeralChord.toString()
                            changedChord = chordChanged + restOfChord;
                        }
                    }
                }else{
                        const chordSymbol = new ChordSheetJS.parseChord(Chord);
                        const numeralChord = chordSymbol.toNumeral(key);
                        changedChord = numeralChord.toString();
                }
            }
            return changedChord;
        }
        
        function displayScore(degree, ifTranspose){
            const chordSheet = `
            {title: <?php echo $post->song->title; ?>}
            `.substring(1) + changeSong(degree, ifTranspose);
            const parser = new ChordSheetJS.ChordProParser();
            const song = parser.parse(chordSheet);
            const formatter = new ChordSheetJS.HtmlTableFormatter();
            const disp = formatter.format(song);
            var showChords = document.getElementById('showChordsWithLyrics');
                showChordsWithLyrics.innerHTML = disp;
            /* 注釈を表示  */
            const rows = document.querySelectorAll('.row');
            rows[2].setAttribute('onclick', 'window.alert("{{ $post->artist->name }}"); return false;');
            rows[2].setAttribute('style', 'width:-moz-fit-content; width:fit-content;');
            rows[2].classList.add('claim')
        }
        
        window.onload = function(){
            displayScore(0, 1); /*楽譜を表示*/
            var Element = document.getElementById("divSelect");
            /*キーを選ぶセレクトボックス生成*/
            var select = document.createElement("select");
                select.id = "select";
                select.setAttribute('onchange', "displayScore(select.value, 1)");
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
