<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <link rel="stylesheet" href="css/comune.css">
</head>
<body>
    <?php
        include "php_scripts/grab_token.php";

        $token = get_token();

        $aid = $_GET['album_id'];

        echo $aid;
    ?>
</body>
</html>