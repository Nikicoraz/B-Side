<?php
    if($_SERVER["REQUEST_METHOD"] =="POST"){
        include_once "connect_db.php";
        $conn = connect();
        $user = $_POST["user"];
        $album = $_POST["aid"];
        $user_log = $_POST["user_log"];
        
        $query = "SELECT dislikes FROM reviews WHERE user_id = '$user' AND album_id = '$album' LIMIT 1";
        $res2 = $conn->query($query);
        $dislikes=0;
        if($res2->num_rows != 0){
            while ($row = $res2->fetch_assoc()){
                $dislikes = $row['dislikes'];
            }
            $dislikes--;
            $query2 = "UPDATE reviews SET dislikes = '$dislikes' WHERE user_id = '$user' AND album_id = '$album'";
            mysqli_query($conn, $query2);
        }
        $query3 = "DELETE FROM dislikes WHERE user = '$user_log'  AND reviewer_id =' $user' AND album_id = '$album'";
        mysqli_query($conn, $query3);
    }
?>