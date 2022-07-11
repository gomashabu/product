window.addEventListener('load', formSwitch());

function formSwitch() {
    var score_type = document.getElementsByName('score_type')
    if (score_type[0].checked) {
        document.getElementsByClassName('score')[0].style.display = "";
        document.getElementsByClassName('FlatScore')[0].style.display = "none";
    } else{
        document.getElementsByClassName('score')[0].style.display = "none";
        document.getElementsByClassName('FlatScore')[0].style.display = "";
    }
}