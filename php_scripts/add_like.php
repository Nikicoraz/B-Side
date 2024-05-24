<?php
    if($_SERVER["REQUEST_METHOD"] =="POST"){
        include_once "connect_db.php";
        $conn = connect();
        $user = $_POST["user"];
        $user_log = $_POST["user_log"];
        $album = $_POST["aid"];

      //  $sql = "SELECT user_id FROM user WHERE username = '$user' LIMIT 1";
       // $res1 = $conn->query($sql);
      //  $us_id=0;
      //  if($res1->num_rows > 0){
      //      while ($row = $res1->fetch_assoc()){
       //         $us_id = $row['user_id'];
       //     }
        //}

        $query = "SELECT likes FROM reviews WHERE user_id = '$user' AND album_id = '$album' LIMIT 1";
        $res2 = $conn->query($query);
        $likes=0;
        if($res2->num_rows != 0){
            while ($row = $res2->fetch_assoc()){
                $likes = $row['likes'];
            }
            $likes++;
            $query2 = "UPDATE reviews SET likes = '$likes' WHERE user_id = '$user' AND album_id = '$album'";
            mysqli_query($conn, $query2);
        }
        $query3 = "INSERT INTO likes (user,reviewer_id,album_id) VALUES ('$user_log','$user','$album')";
        mysqli_query($conn, $query3);
        
    }
?>