<?php
    include "php_scripts/grab_token.php";
    include "php_scripts/search_album.php";

    $token = get_token();

    $aid = $_GET['album_id'];
    if(!$aid){
        die("Nessun ID");
    }

    $album = search_album_by_id($token, $aid);

    session_start();
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
                <?php 
                    if(isset($_SESSION["username"])){
                        echo "<p>" . $_SESSION["username"] . "</p>";
                        echo "<a href=\"php_scripts/logout.php\">Logout</a>";
                    }else{
                        echo "<a href=\"login.php\">Login/Register</a>";
                    }
                ?>
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

    <!-- REVIEWS -->

    <?php
        include_once "php_scripts/connect_db.php";
        $conn = connect();
        $user = "";
        if(isset($_SESSION["username"])){
            $user_rev ="SELECT * FROM Reviews r JOIN User u ON u.user_id = r.user_id AND r.album_id = '$aid' WHERE u.username = '$_SESSION[username]'";
            $user_rev_res = $conn->query($user_rev);
            if($user_rev_res->num_rows == 1){
                $row = $user_rev_res->fetch_assoc();
                echo"<form id='user_review'>";
                echo"<h1>Your Review</h1>";    
                echo"<p>".$row['username']."</p>";
                echo"<textarea disabled>".$row['corpus']."</textarea>";
            }else if($user_rev_res->num_rows == 0){
                echo"<p>Non hai inserito alcuna recensione..</p>";
                ?>
                <form class="reviews" id="reviewForm" method = "post" action = "php_scripts/insert_review.php" username="<?php echo $_SESSION['username'] ?>" album="<?php echo $aid ?>">
                    <textarea name = "review_body" placeholder="Scrivi la tua recensione...." minlength="50" required></textarea>
                    <input type="submit" value = "Invia">
                </form>
                <?php
                echo"</form>";
            }else{
                echo"<p>Devi registrarti per poter recensire gli album.... </p><a id= 'registration' href = 'register.php'>Registrati qui</a>";
            }
        }
        ?>
    <div id = "reviews_list">
    <h1>Recensioni di altri utenti</h1>

    <?php 
        $sql = "SELECT * FROM Reviews r JOIN User u ON r.user_id = u.user_id AND r.album_id = '$aid'";
        $res = $conn->query($sql);
        if($res->num_rows == 0){
            echo"<p>Nessuna recensione da parte di altri utenti :( </p>";
        }else{
            while($row = $res->fetch_assoc()){
                if(isset($_SESSION["username"])){ 
                    if($row["username"] != $_SESSION["username"]){    
                        echo"<div id = 'other_user_review' user = ".$row['username'].">";
                        echo"<img src='https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png' alt='' id='review_profile-image'>";
                        echo"<p>".$row['username']."</p>";
                        echo"<textarea disabled>".$row['corpus']."</textarea>";
        ?>
                    <button id = "blike" onclick="checklike()">
                        <img src ="./images/like.png" id = "like">
                    </button>
                    <button id = "bdislike" onclick="checkdislike()">
                        <img src ="images/dislike.png" id = "dislike" >
                    </button>
                    <?php
                    }
                }
            }
        }
        ?>
        
        </div> 
    </div>
    <script src="js/nav.js"></script>
    <script src="js/sendReview.js"></script>
    <script src="js/like.js"></script>
</body>
</html>