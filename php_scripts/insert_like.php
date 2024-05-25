<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once(dirname(__FILE__) . "/connect_db.php");

        $user = $_POST['user'];
        $album = $_POST['album'];
        $type = $_POST['type'];
        $rev_user = $_POST['rev_user'];
        $action = $_POST['action'];

        $conn = connect();



        if($action == "insert") {
            if($statement = $conn->prepare("INSERT INTO likes (user_id, album_id, type, liking_user_id) VALUES (?, ?, ?, ?)")) {
                $statement->bind_param('issi', $rev_user, $album, $type, $user);

                $statement->execute();

                $statement->close();
            }
        }else if($action == "delete") {
            if($statement = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND album_id = ? AND liking_user_id = ? AND type = ?")) {
                $statement->bind_param('isis', $rev_user, $album, $user, $type);

                $statement->execute();

                $statement->close();
            }
        }
    }
?>