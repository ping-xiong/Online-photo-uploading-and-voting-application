function hide_all() {
    $("#homepage").css("display", "none");
    $("#upload").css("display", "none");
    $("#help").css("display", "none");
}

function switchMenu(target) {
    hide_all();
    $("#"+target).css("display", "block");
}