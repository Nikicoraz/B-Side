const likes = (() => {
    const arr = [...document.getElementsByClassName("like"), ...document.getElementsByClassName("dislike")];

    const like = "like.png";
    const like_checked = "like_checked.png";

    const dislike = "dislike.png";
    const dislike_checked = "dislike_checked.png";

    function sendRequest(e, data, src, callback){
        fetch("./php_scripts/insert_like.php", {
            method: "POST",
            body: data
        }).then(res => res.text()).then(data => {
            if(data != ""){
                console.log(data);
            }else{
                if(e.classList == "like"){
                    if(src == like){
                        e.src = "images/" + like_checked;
                        e.parentElement.children[1].innerHTML = Number(e.parentElement.children[1].innerHTML) + 1;
                    }else{
                        e.src = "images/" + like;
                        e.parentElement.children[1].innerHTML = Number(e.parentElement.children[1].innerHTML) - 1;
                    }
                    
                }else if(e.classList == "dislike"){
                    if(src == dislike){
                        e.src = "images/" + dislike_checked;
                        e.parentElement.children[3].innerHTML = Number(e.parentElement.children[3].innerHTML) + 1;
                    }else{
                        e.src = "images/" + dislike;
                        e.parentElement.children[3].innerHTML = Number(e.parentElement.children[3].innerHTML) - 1;
                    }
                }
            }
            callback();
        });
    }

    arr.forEach(e => {
        
        e.addEventListener("click", event =>{
            let data = new FormData();
            const user = e.parentElement.getAttribute("user");
            const album = e.parentElement.getAttribute("album");
            const rev_user = e.parentElement.getAttribute("rev_user");
            
            
            const src = e.src.split("/").slice(-1)[0];
            data.append("user", user);
            data.append("album", album);
            data.append("rev_user", rev_user);

            if(e.classList == "like"){
                data.append("type", "like");

                if(src == like){
                    data.append("action", "insert");
                }else if(src == like_checked){
                    data.append("action", "delete");
                }

                if(e.parentElement.children[2].src.split("/").splice(-1)[0] == dislike_checked){
                    let tempData = new FormData();
                    tempData.append("user", user);
                    tempData.append("album", album);
                    tempData.append("type", "dislike");
                    tempData.append("action", "delete");
                    tempData.append("rev_user", rev_user);

                    sendRequest(e.parentElement.children[2], tempData, src, () => {sendRequest(e, data, src, () => {})})
                }else{
                    sendRequest(e, data, src, () => {});
                }
            }else if(e.classList == "dislike"){
                data.append("type", "dislike");
                if(src == dislike){
                    data.append("action", "insert");
                }else if(src == dislike_checked){
                    data.append("action", "delete");
                }

                if(e.parentElement.children[0].src.split("/").splice(-1)[0] == like_checked){
                    let tempData = new FormData();
                    tempData.append("user", user);
                    tempData.append("album", album);
                    tempData.append("type", "like");
                    tempData.append("action", "delete");
                    tempData.append("rev_user", rev_user);


                    sendRequest(e.parentElement.children[0], tempData, src, () => {sendRequest(e, data, src, () => {})})
                }else{
                    sendRequest(e, data, src, () => {});
                }
            }

            
        });
    });
})()
