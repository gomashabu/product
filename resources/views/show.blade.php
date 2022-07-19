@extends('layouts.app')

@section('css')
    {{ asset('css/show.css') }}
@endsection

@section('content')
    <!-- モーダル表示用のdiv -->
    @foreach ($claimsByRows as $claimsByRow)
        <!--modal fadeでフェードイン tabindexが負なのでtabキーによる指定は不可-->
        <div class="modal fade" id="claimModal{{ array_search($claimsByRow, $claimsByRows) }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4><div class="modal-title" id="myModalLabel">指摘</div></h4>
                    </div>
                    <div class="modal-body">
                        <label>
                                @foreach ($claimsByRow as $value)
                                <div class='commentList'>
                                    <p class='comment'>{{ $value->claim }}"</p>
                                    <p class='user'>- {{ $value->user->name }}</p>
                                    <br>
                                </div>
                                @endforeach
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="spaceForNaavBar" style="margin-bottom: 80px;"></div>
    <div class='post'>
        <div class="aboveScore">
            <div class="changeScore">
                <div>
                    @if($post->key)
                        <p>コードタイプ</p>
                    @endif
                    <p>曲のキー</p>
                </div>
                <div>
                    @if($post->key)
                        <div class="chord_type">
                            <select id="selectChordType" onchange="displayScore(selectChordType.value, '0')">
                                <option value='symbol'>Chord Symbols (e.g. C#m, G7)</option>
                                <option value='numeral'>Numeral Chords (e.g. Im, V7)</option>
                            </select>
                        </div>
                    @endif
                    <div id='divSelect'>
                    </div>
                </div>
            </div>
            <div class="changeCharSize">
                <p>文字サイズの変更</p>
                <div class="sizeButtonWithText">
                    <div>
                        <p>コード</p>
                        <p>歌詞</p>
                    </div>
                    <div class="sizeButton">
                        <div class="chordSizeButton">
                            <button type="button" onclick="changeSize('chord', '+')">+</button>
                            <button type="button" onclick="changeSize('chord', '-')">-</button>
                        </div>
                        <div class="lyricsSizeButton">
                            <button type="button" onclick="changeSize('lyrics', '+')">+</button>
                            <button type="button" onclick="changeSize('lyrics', '-')">-</button>
                        </div>
                    </div>
                </div>
            </div>
            @if ($id == $post->user->id)
            <div class="forPoster">
                <p class="edit">[<a href="/posts/{{ $post->id }}/edit">edit this post</a>]</p>
                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="deleteButton">delete this post</button> 
                </form>
            </div>
        @endif
        </div>
        <div class='postTitle'>
            <h1>{{ $post->song->title }}</h1>
            <h3 id="byBetTitle">by</h3>
            <h2><a href="/ranking/songsOfAnArtist/{{ $post->artist->id }}">{{ $post->artist->name }}</a></h2>
            <br>
            <h6 class="float-right">posted by {{ $post->user->name }}</h6>
        </div>
        <p id = "showChordsWithLyrics"></p>
    </div>
    <div class="footer">
        <div>
            <a href="/">Back</a>
        </div>
        @if (Auth::check())
            <div>
                <a href="/posts/{{ $post->id }}/claim">指摘をする</a>
            </div>
        @endif
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
    </div>
    <div class='comments'>
        <h3>Comments</h3>
        @if (Auth::check())
            <form action="/posts/{{ $post->id }}/comment" method="POST">
                @csrf
                <textarea class='textarea'  id='CommentInput' name="comment" placeholder="Enter your comment" rows="5" cols="50" >{{ old('comment') }}</textarea>
                <input type="submit" value="保存" />
            </form>
        @endif
        @foreach ($comments as $comment)
            <div class='commentList'>
                <p class='comment'>{{ $comment->comment }}</p>
                <p class='user'>- {{ $comment->user->name }}</p>
            </div>
        @endforeach
    </div>
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
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "1");
                            restOfChord = /.(.*)/g.exec(restOfChord)[1];
                            changedChord = chordBass + restOfChord;
                        }else if(keySig == "b"){
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
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
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "1");
                            changedChord = chordBass;
                        }else if(keySig == "b"){
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            const numeralChord = chordSymbol.toNumeral(key);
                            var chordBass =transposeChord(numeralChord.toString(), "-1");
                            changedChord = chordBass;
                        }else{
                            const chordSymbol = new ChordSheetJS.parseChord(Chord);
                            const numeralChord = chordSymbol.toNumeral(key);
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
            console.log(degree);
            const chordSheet = `
            `.substring(1) + changeSong(degree, ifTranspose);
            const parser = new ChordSheetJS.ChordProParser();
            const song = parser.parse(chordSheet);
            const formatter = new ChordSheetJS.HtmlTableFormatter();
            const disp = formatter.format(song);
            var showChords = document.getElementById('showChordsWithLyrics');
                showChordsWithLyrics.innerHTML = disp;
            /* 注釈を表示  */
            const rows = document.querySelectorAll('.row');
            @json($claimRows).forEach(function(claimRow){
                rows[claimRow].setAttribute('style', 'width:-moz-fit-content; width:fit-content;');
                rows[claimRow].setAttribute('data-toggle', 'modal');
                rows[claimRow].setAttribute('data-target', "#claimModal" + claimRow);
                rows[claimRow].classList.add('claim')
            });
        }
        
        function changeSize(char, upOrDown){
            /* クラス名がchar(lyricsもしくはchord)である要素の一つ目を取得し、そのfontsizeを取得 */
            var fontSizePx = window.getComputedStyle(document.getElementsByClassName(char)[0]).getPropertyValue('font-size');
            var fontSize = fontSizePx.replace(/[^0-9|.]/g, '');
            console.log(typeof(document.getElementsByClassName(char)))
            var charArray = document.getElementsByClassName(char);
            if(upOrDown == "+"){
                Object.keys(charArray).forEach(function(char){
                    charArray[char].style.fontSize = Number(fontSize) + 0.4 + "px";
                });
            }else if(upOrDown == "-"){
                Object.keys(charArray).forEach(function(char){
                    charArray[char].style.fontSize = Number(fontSize) - 0.4 + "px";
                });
            }
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
