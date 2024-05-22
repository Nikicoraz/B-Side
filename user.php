<?php 
    if(isset($_GET['username']))
        $username = $_GET['username'];
    else
        die("<h1>User not found! :/</h1>");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $username ?></title>
    <link rel="stylesheet" href="css/comune.css">
</head>
<body> 
    <nav>
        <h1><?php echo $username ?> </h1>
    </nav>
    <?php 
        include "php_scripts/connect_db.php";
        $conn = connect();

        $stmt = $conn->prepare("SELECT user_id, bio FROM User WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 0) {
            echo "<h1>User not found! :/</h1>";
        } else {
            $user = $result->fetch_assoc();
            $id = $user['user_id'];
            $bio = $user['bio'];

            $stmt = $conn->prepare("SELECT album_id, title, corpus FROM reviews WHERE user_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $reviewsResult = $stmt->get_result();
        }

        echo "<div class='main-div'>";
        echo "<h1>Bio</h1>";
        echo "<p>" . nl2br(htmlspecialchars($bio)) . "</p>";
        echo "</div>";
        
        echo "<div class='main-div'>";
        echo "<h1>Reviews</h1>";
        $found = false;
        while ($review = $reviewsResult->fetch_assoc()) {
            echo "<div class='review'>";
            echo "<h2>" . htmlspecialchars($review['title']) . "</h2>";
            //TODO album image (?)
            echo "<p>" . nl2br(htmlspecialchars($review['corpus'])) . "</p>";
            echo "</div>";
            $found = true;
        }

        if(!$found)
            echo "<h2>No reviews found :(</h2>";

        echo "</div>";
        $stmt->close();
        $conn->close();
    ?>
</body>
</html>