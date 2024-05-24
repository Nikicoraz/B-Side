function checklike(param){
    let data = new FormData();
    let padre = param.parentElement;
    let dislike = padre.children[2];
    let like_counter = padre.children[1];
    let dislike_counter = padre.children[3];

    let n_like = parseInt(like_counter.innerHTML);
    let n_dislike = parseInt(dislike_counter.innerHTML);


    data.append("user", padre.getAttribute("user"));
    data.append("aid", padre.getAttribute("album"));
    data.append("user_log", padre.getAttribute("user_log"));
    if(param.src == "http://localhost/B-Side-master/images/like.png") {
        param.src = "http://localhost/B-Side-master/images/like_checked.png";
        
        if(dislike.src == "http://localhost/B-Side-master/images/dislike_checked.png") { 
            dislike.src = "http://localhost/B-Side-master/images/dislike.png";

            fetch("./php_scripts/removeDislike.php", {
                method: "POST",
                body: data
                }).then(res => res.text())
                .then(txt => console.log(txt))
                .catch(err => console.error(err));

            n_dislike--;    
        }
        
        fetch("./php_scripts/addlike.php", {
            method: "POST",
            body: data
            }).then(res => res.text())
            .then(txt => console.log(txt))
            .catch(err => console.error(err));
            n_like++;

    }else{
        param.src = "http://localhost/B-Side-master/images/like.png";
        fetch("./php_scripts/removelike.php", {
            method: "POST",
            body: data
            }).then(res => res.text())
            .then(txt => console.log(txt))
            .catch(err => console.error(err));
            n_like--;

    }

    like_counter.innerHTML = ""+n_like;
    dislike_counter.innerHTML = ""+n_dislike;
};

function checkdislike(param){
    let padre = param.parentElement;
    let like = padre.children[0];
    let data = new FormData();

    let like_counter = padre.children[1];
    let dislike_counter = padre.children[3];

    let n_like = parseInt(like_counter.innerHTML);
    let n_dislike = parseInt(dislike_counter.innerHTML);

    data.append("user", padre.getAttribute("user"));
    data.append("aid", padre.getAttribute("album"));
    data.append("user_log", padre.getAttribute("user_log"));
    if(param.src == "http://localhost/B-Side-master/images/dislike.png") {
        param.src = "http://localhost/B-Side-master/images/dislike_checked.png";
        
        
        if(like.src == "http://localhost/B-Side-master/images/like_checked.png") { 
            like.src = "http://localhost/B-Side-master/images/like.png";

            fetch("./php_scripts/removelike.php", {
                method: "POST",
                body: data
                }).then(res => res.text())
                .then(txt => console.log(txt))
                .catch(err => console.error(err));
                n_like--;
        }
        
        fetch("./php_scripts/addDislike.php", {
            method: "POST",
            body: data
            }).then(res => res.text())
            .then(txt => console.log(txt))
            .catch(err => console.error(err));
            n_dislike++;
    }else{
        param.src = "http://localhost/B-Side-master/images/dislike.png";

        fetch("./php_scripts/removeDislike.php", {
            method: "POST",
            body: data
            }).then(res => res.text())
            .then(txt => console.log(txt))
            .catch(err => console.error(err));
            n_dislike--;
    }

    like_counter.innerHTML = ""+n_like;
    dislike_counter.innerHTML = ""+n_dislike;
};