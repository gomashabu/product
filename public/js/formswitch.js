window.addEventListener('load', formSwitch());

function formSwitch() {
    var score_type = document.getElementsByName('score_type');
    console.log(score_type[1].checked);
    if (score_type[0].checked) {
        document.getElementsByClassName('score')[0].style.display = "";
        document.getElementsByClassName('FlatScore')[0].style.display = "none";
        console.log("a");
    } else if(score_type[1].checked){
        document.getElementsByClassName('score')[0].style.display = "none";
        document.getElementsByClassName('FlatScore')[0].style.display = "";
        console.log("b");
    }
}

function test(){
    console.log("test");
}