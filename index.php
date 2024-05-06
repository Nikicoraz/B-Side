<?php
    // ------------------
    // Per ottenere il token serve creare un file .env con le seguenti informazioni:
    // CLIENT_ID = <id>
    // CLIENT_SECRET = <secret>
    // Queste informazioni vengono fornite dall'applicazione su spotify for developers
    // ------------------


    include "php_scripts/grab_token.php";
    include "php_scripts/search_album.php";

    // Codice per ottenere il token 
    $token = get_token();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>B Side</title>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <nav>
        <h1>B-SIDE</h1>
        <div id="search-div">
            <input type="text" placeholder="Cerca..." name="ricerca" id="ricerca">
            <div id="results"></div>
        </div>
        <div>
            <div id="user">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="" id="profile-image">
                <p>Username</p>
            </div>
        </div>
    </nav>

    <div id="catchphrase" class="main-div">
        <h2>La musica per chi ama condividere</h2>
    </div>

    <div class="main-div">
        <h1>Nuove uscite!</h1>
        <div id="nuove-uscite">
            <div class="album">
                <img src="https://i.scdn.co/image/ab67616d0000b27347725a3bcf424bf5c8d98aec" alt="">
                <h3>Symphony No. 9 in D Minor, Op. 125 "Choral"</h3>
            </div>
            <div class="album">
                <img src="https://i.pinimg.com/originals/c0/53/54/c0535410a15a60839564c8c10eb6587a.jpg" alt="">
                <h3>Quattro Stagioni</h3>
            </div>
            <div class="album">
                <img src="https://www.ibs.it/images/5400863054984_0_536_0_75.jpg" alt="">
                <h3>Concerti Brandeburghesi</h3>
            </div>
        </div>
    </div>

    <div class="main-div flexable">
        <div class="album">
            <h3>Album random</h3>
            <img src="https://m.media-amazon.com/images/I/715LZJ5qX0L._UF1000,1000_QL80_.jpg" alt="">
            <h3>Ok Computer</h3>
        </div>
        <div class="album">
            <h3>Album del giorno</h3>
            <img src="https://m.media-amazon.com/images/I/51Ozg3raqjL._UXNaN_FMjpg_QL85_.jpg" alt="">
            <h3>Padre e Figlio</h3>
        </div>
    </div>
    <script>
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
                            document.getElementById("results").innerHTML = data;
                        }
                    })
            }, 500);
        });
    </script>
</body>
</html>