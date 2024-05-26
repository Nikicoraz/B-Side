<?php
    include_once 'connect_db.php';
    $c = connect();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_POST["username"])){
            die(401);
        }else{
            $usr =  $_POST['username'];
            $res = $c->query("SELECT user_id FROM  user WHERE username ='$usr' LIMIT 1");
            while ($row = $res->fetch_assoc()) {
                $usr_id = $row['user_id'];
            }

            if($c->query("SELECT * FROM reviews WHERE user_id = '$usr_id' AND album_id = '$_POST[album_id]'")->num_rows > 0){
                die(409);
            }
            $insert = "INSERT INTO reviews VALUES (?,?,?,?)";
            if($stmt = $c->prepare($insert)){
                $aid = $_SESSION["album_id"];
                $title = "";
                $body = $_POST["review_body"];
                $stmt->bind_param("isssii",$usr_id,$aid,$title,$body);
                $stmt->execute(); 
                $stmt->close();
            }
        }
    }
?>
</html> 
