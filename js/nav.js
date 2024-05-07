const ricerca = document.getElementById("ricerca");

        let ricerca_id = -1;
        ricerca.addEventListener("input", (e) => {
            if(ricerca_id != -1){
                clearTimeout(ricerca_id);
            }

            console.log("Change");
            let data = new FormData();
            data.append("album_name", ricerca.value);

            ricerca_id = setTimeout(() => {
                fetch("./php_scripts/search_album.php", {
                    method: "POST",
                    body: data,
                    }).then((res) => 
                        res.text()
                    ).then(data => {
                        if(data.error){
                            if(data.error.status == 401){
                                console.log("hihihiha");
                            }
                        }else{
                            if(data && data != ""){
                                document.getElementById("results").style.display = "block";
                                document.getElementById("results").innerHTML = data;
                            }else{
                                document.getElementById("results").style.display = "none";
                            }
                        }
                    })
            }, 500);
        });