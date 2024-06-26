<?php 
    include "php_scripts/grab_token.php";
    include "php_scripts/search_album.php";
    
    $token = get_token();
    session_start();

    if(isset($_GET['username']))
        $username = urldecode($_GET['username']);
    else
        die("<h1>Utente non trovato! :/</h1>");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username ?></title>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/user.css">
</head>
<body> 
    <?php 
        $conn = connect();
        $stmt = $conn->prepare("SELECT user_id, bio FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 0) {
            echo "<h1>Utente non trovato! :/</h1>";
            echo "<a href=\"index.php\">Torna alla homepage</a>";
        } else {
            echo "<nav>";
            echo "<h1> <a href=\"index.php\" id = \"navTitle\"> B-SIDE </a> </h1>";
            echo "<h1> <img id = \"logo\" src = \"disc.png\"> </h1>";
            echo "<h1>" . $username . "</h1>";
            echo "</nav>";
            $user = $result->fetch_assoc();
            $id = $user['user_id'];
            $bio = $user['bio'];

            $stmt = $conn->prepare("SELECT album_id, title, corpus FROM reviews WHERE user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $reviewsResult = $stmt->get_result();

            echo "<div class='main-div'>";
            echo "<h1>Bio</h1>";
            echo "<p>" . nl2br(htmlspecialchars($bio)) . "</p>";
            echo "</div>";
        
            echo "<div class='main-div'>";
            echo "<h1>Reviews</h1>";
        
            $found = false;
            while ($review = $reviewsResult->fetch_assoc()) {
                $album = search_album_by_id($token, $review['album_id']);
                $image_url = $album['images'][0]['url']; 
                $album_name = htmlspecialchars($album['name']);
                $album_release_date = htmlspecialchars($album['release_date']);
                $album_artist = htmlspecialchars($album['artists'][0]['name']);
                ?>

                <div class='review'>
                    <a class="review-left" href="album.php?album_id=<?php echo $album['id'] ?>">
                        <div>
                            <img src="<?php echo $image_url; ?>" alt="Album Image">
                            <div class="album-info">
                                <h3><?php echo $album_name; ?></h3>
                                <p>Artist: <?php echo $album_artist; ?></p>
                                <p>Released: <?php echo $album_release_date; ?></p>
                            </div>
                        </div>
                    </a>
                    <div class="review-right">
                        <h2><?php echo htmlspecialchars($review['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($review['corpus'])); ?></p>
                    </div>
                </div>
                <?php
                $found = true;
            }
        
            if(!$found)
                echo "<h2>No reviews found :(</h2>";

            echo "</div>";
        }
        $stmt->close();
        $conn->close();
    ?>

    <?php
        // controllo che l'utente loggato sia quello della pagina, in modo che possa modificare la propria pagina 
        if(isset($_SESSION["username"])) {
            if ($_SESSION["username"] == $username) {
                echo "<div>";
                    echo "<a href=\"./user_settings.php\"><button>Manage profile</button></a>";
                echo "</div>";
            }
        }
    ?>
</body>
</html>
