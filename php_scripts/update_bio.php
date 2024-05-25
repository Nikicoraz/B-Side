<?php
    include "connect_db.php";

    // update della bio
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $username = $_SESSION["username"];

        if (isset($_POST["new_bio"])) {
            $new_bio = $_POST["new_bio"];

            $conn = connect();
            $stmt = $conn->prepare("UPDATE user SET bio = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_bio, $username);

            if ($stmt->execute()) { // Si reinderizza alla pagina profilo
                header("Location: ../user.php?username=" . urlencode($_SESSION["username"]));    
            }

            $conn->close();
        }
    }
    
    echo "<div> There was an error trying to update the user's bio </div>";
?>