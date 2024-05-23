<html> 
    <head>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/insert_review.css">
    </head>
<?php
    session_start();
    include_once 'connect_db.php';
    $c = connect();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_SESSION["username"])){
            die("You must be signed to send reviews... Please sign in");
        }else{
            $usr =  $_SESSION['username'];
            $res = $c->query("SELECT user_id FROM  user WHERE username ='$usr' LIMIT 1");
            while ($row = $res->fetch_assoc()) {
                $usr_id = $row['user_id'];
            }
            $insert = "INSERT INTO reviews VALUES (?,?,?,?)";
            if($stmt = $c->prepare($insert)){
                $aid = $_SESSION["album_id"];
                $title = "";
                $body = $_POST["review_body"];
                $stmt->bind_param("isss",$usr_id,$aid,$title,$body);
                $stmt->execute(); 
                $stmt->close();
                echo "<script>window.location.href = '.././index.php';</script>";
            }
        }
    }
?>
</html> 