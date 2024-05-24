<?php
    include "connect_db.php";

    // update dello username
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $username = $_SESSION["username"];

        if (isset($_POST["new_username"])) {
            $new_username = $_POST["new_username"];

            $conn = connect();
            $stmt = $conn->prepare("UPDATE user SET username = ? WHERE username = ?");
            $stmt->bind_param("ss", $new_username, $username);

            $_SESSION["username"] = $new_username;

            if ($stmt->execute()) { // Si reinderizza alla "nuova" pagina profilo
                header("Location: ../user.php?username=" . urlencode($_SESSION["username"]));    
            }

            $conn->close();
        }
    }
    
    echo "<div> There was an error trying to update the username </div>";
?>