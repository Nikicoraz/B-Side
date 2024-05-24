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

    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>B Side</title>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/results.css">
</head>
<body>
    <nav>
        <h1><a href="./" id = "navTitle">B-SIDE</a></h1>
        <h1><img id = "logo" src = "disc.png"></h1>
        <div id="search-div">
            <input type="text" placeholder="Cerca..." name="ricerca" id="ricerca">
            <div id="results"></div>
        </div>
        <div>
            <div id="user">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="" id="profile-image">
                <?php 
                    if(isset($_SESSION["username"])){
                        echo "<a href=\"user.php?username=$_SESSION[username]\">" . $_SESSION["username"] . "</a>";
                        echo "<a href=\"php_scripts/logout.php\" class=\"logout\">Logout</a>";
                    }else{
                        echo "<a href=\"login.php\">Login/Register</a>";
                    }
                ?>
            </div>
        </div>
    </nav>

    <div id="catchphrase" class="main-div">
        <h2>La musica per chi ama condividere</h2>
    </div>

    <div class="main-div">
        <h1>Nuove uscite!</h1>
        <div id="nuove-uscite">
            <?php 
                $curl = curl_init("https://api.spotify.com/v1/browse/new-releases?limit=3");

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

                $ret = curl_exec($curl);

                if ($ret === false) {
                    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                    if ($http_code == 401) {
                        $token = grab_new_token();
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));
                        $ret = curl_exec($curl);

                        if ($ret === false) {
                            echo "Errore curl: " . curl_error($curl);
                            var_dump(curl_getinfo($curl));
                            exit;
                        }
                    } else {
                        echo "Errore curl: " . curl_error($curl);
                        var_dump(curl_getinfo($curl));
                        exit;
                    }
                }

                $new_releases = json_decode($ret, true);
                curl_close($curl);

                if (!empty($new_releases['albums']['items'])) {
                    foreach ($new_releases['albums']['items'] as $album) {
                        echo '<div class="album">';
                        echo '<img src="' . $album['images'][0]['url'] . '" alt="' . htmlspecialchars($album['name']) . '">';
                        echo '<h3>' . htmlspecialchars($album['name']) . '</h3>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo '<p>Non ci sono nuove uscite disponibili al momento.</p>';
                }
        ?>
        </div>
    </div>
    <script src="js/nav.js"></script>
</body>
</html>