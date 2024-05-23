function checklike(){
    let padre = document.getElementById("like").parentElement();
    let utente = padre.getAttribute("user");
    if(document.getElementById("like").getAttribute("src") == "../images/like.png") {
        document.getElementById("like").getAttribute("src") = "../images/like_checked.png";
        document.getElementById("dislike").getAttribute("src") = "../images/dislike.png";
    }
};

function checkdislike(){
    let padre = document.getElementById("dislike").parentElement();
    let utente = padre.getAttribute("user");
    if(document.getElementById("dislike").src == "../images/dislike.png") {
        document.getElementById("dislike").src = "../images/dislike_checked.png";
        document.getElementById("like").src = "../images/like.png";
    }
};
