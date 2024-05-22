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
    <title><?php $username ?></title>
    <link rel="stylesheet" href="css/comune.css">
</head>
<body>
    <?php 
        include "php_scripts/connect_db.php";
        $conn = connect();

        $bio = $conn->query("SELECT bio FROM User WHERE username = '$username'");
        $reviews = $conn->query("SELECT * FROM reviews WHERE ") //id 
    ?>
</body>
</html>