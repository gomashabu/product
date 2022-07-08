window.addEventListener('load', formSwitch());

function formSwitch() {
    let score_type = document.getElementsByName('score_type')
    
    if (score_type[0].checked) {
        document.getElementsByClassName('score')[0].style.display = "";
        document.getElementsByClassName('FlatScore')[0].style.display = "none";
    } else if (score_type[1].checked) {

        document.getElementsByClassName('score')[0].style.display = "none";
        document.getElementsByClassName('FlatScore')[0].style.display = "";
    } else {
        document.getElementsByClassName('score')[0].style.display = "none";
        document.getElementsByClassName('FlatScore')[0].style.display = "none";
    }
}






var lastInputChord = {};
var lastInputLyrics = {};
var inputType = null;
var eventData = null;
var paste = null;

//アロー関数
var reflectLyrics = () => {
    //lyricsInputへの入力を、改行で分けられた配列にする
    var textbox = document.getElementById("lyricsInput");
    var textboxArray = textbox.value.split(/\r\n|\n/);
    //入力前のカーソル位置までの文字列を取得
    var start = textbox.selectionStart;
    var  textboxArrayUpToStart = textbox.value.substr(0, start).split(/\r\n|\n/);
    //console.log(textboxArrayUpToStart.length-1);
    
    if(event.inputType === "insertFromPaste"){
        //ペーストされた内容を取得
        console.log("if文に入れた")
        console.log(document.getElementById("lyricsInput"));
        document.getElementById("lyricsInput").addEventListener('paste', (event) => {
                console.log("addEventListener発火" );
        });
        
    }
    //ペーストの時
    // if(event.inputType === "insertFromPaste"){
    //     //ペーストされた内容を取得
    //     document.getElementById("lyricsInput").addEventListener('paste', (event) => {
    //         var paste = (event.clipboardData || window.clipboardData).getData('text');
    //         //n行目まではコードを保持
    //         var n = textboxArrayUpToStart.length - paste.split(/\r\n|\n/).length;
    //     console.log("スタートまで" + textboxArrayUpToStart.length);
    //     console.log(paste.split(/\r\n|\n/).length);
    //     });
        
    // }
    
    //ペースト以外の時
    
    
//     var end = textbox.selectionEnd;
//     console.log("スタート" + start);
//     console.log(end);
  

    //前のinputと比較 昇順と降順で全配列を比較
    // if(lastInputLyrics.length !== undefined){
    //     var matchedLine = [0,0];
    //     console.log(Math.min(textboxArray.length, lastInputLyrics.length));
    //     for (var i = 0 ; i < Math.min(textboxArray.length, lastInputLyrics.length) ; i++){
    //         if(lastInputLyrics[i] !== textboxArray[i]){
    //             console.log(textboxArray.length)
    //             console.log(lastInputLyrics.length)
    //             matchedLine[0] = i-1;
    //             break;
    //         }
    //         if(i === Math.min(textboxArray.length, lastInputLyrics.length)-1){
    //             matchedLine[0] = i;
    //         }
    //     }
    // }
    // console.log(matchedLine);
    
    //reflectedLyricsをcloneと入れ替えることで、input, p要素を削除する
    var reflectedLyrics = document.getElementById('reflectedLyrics');
    var clone = reflectedLyrics.cloneNode( false );
　　reflectedLyrics.parentNode.replaceChild(clone, reflectedLyrics);
　　
    
    for (var i = 0 ; i < textboxArray.length ; i++){
            //input要素の生成
            var chords = document.createElement('input');
                chords.type = 'text';
                chords.id = 'chordsform_' + i;
                chords.name = 'chords';
            //reflectedLyrics下にchordsを配置
            document.getElementById('reflectedLyrics').appendChild(chords);
            
            //pタグの要素を作成
            var p1 = document.createElement("p");
                p1.id = 'lyrics' + i;
            //文字列を生成し、pタグに挿入
            var text1 = document.createTextNode(textboxArray[i]);
            p1.appendChild(text1);
            document.getElementById('reflectedLyrics').appendChild(p1);
    }
    
    lastInputChord = document.getElementsByName('chords');
    lastInputLyrics = textboxArray;
    inputType = event.inputType;
    eventData = event.data;
}