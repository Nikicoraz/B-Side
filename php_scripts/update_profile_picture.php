<?php
    include "connect_db.php";

    // update della pfp 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $username = $_SESSION["username"];

        $dir = "../images/profile_pictures/";
        $proj_dir = "./images/profile_pictures/";
        
        $conn = connect();
        // prima trovo l'id dell'utente e con quello do il nome al file dell'immagine basandomi su quello
        $stmt = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $id = $result->fetch_assoc()["user_id"];
            $path = $dir . $id . ".jpg";
            $proj_path = $proj_dir . $id . ".jpg";

            if ($_FILES["new_profile_picture"]["size"] < 10000000 && 
                strtolower(pathinfo($_FILES["new_profile_picture"]["name"], PATHINFO_EXTENSION)) == "jpg") { // dimensione massima 10MB e tipo .jpg
                
                if (move_uploaded_file($_FILES["new_profile_picture"]["tmp_name"], $path)) {
                    $stmt = $conn->prepare("UPDATE user SET profile_picture = ? WHERE username = ?;");
                    $stmt->bind_param("ss", $proj_path, $username); // usiamo solo .jpg
                    $stmt->execute();

                    header("Location: ../user.php?username=" . urlencode($_SESSION["username"]));
                } else {
                    die("Errore nel caricamento del file");
                }
            }

        } else {
            die("Errore"); // TODO gestire meglio la cosa
        }

        $conn->close();
    }
?>