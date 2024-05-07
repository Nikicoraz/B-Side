<?php
    include "php_scripts/grab_token.php";
    include "php_scripts/search_album.php";

    $token = get_token();

    $aid = $_GET['album_id'];
    if(!$aid){
        die("Nessun ID");
    }

    $album = search_album_by_id($token, $aid);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $album["name"]; ?></title>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/album.css">
    <link rel="stylesheet" href="css/results.css">
</head>
<body>
    <nav>
        <h1><a href="./">B-SIDE</a></h1>
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
    <div class="main-content">
        <div>
            <img class='cover' src="<?php echo $album["images"][0]["url"]; ?>" alt="">
            <h1>Title: <?php echo $album["name"]; ?></h1>
            <h2>Artist(s): <?php foreach($album["artists"] as $a){ echo "<a target='_blank' href='" . $a['external_urls']['spotify'] . "'>" . $a['name'] . "</a>"; } ?></h2>
            <h3>Release date: <?php echo $album["release_date"]; ?></h3>
            <?php
                if($album['genres']){
                    ?>
                    <h3>Genre: <?php foreach($album["genres"] as $g){ echo $g . " "; } ?></h3>
                    <?php
                }
            ?>
            <a href="<?php echo $album["external_urls"]["spotify"]; ?>" target="_blank"><h4>Spotify link</h4></a>
        </div>
        <div>
            <h1>Tracks:</h1>
            <ul>

                <?php
                foreach($album["tracks"]["items"] as $t){
                    echo "<li><a target='_blank' href='" . $t["external_urls"]["spotify"] . "'>" . $t["name"] . "</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="reviews">
        <h1>Reviews</h1>
        <textarea placeholder="Leave a review..."></textarea>
        <button>Send</button>
    </div>
    <script src="js/nav.js"></script>
</body>
</html>