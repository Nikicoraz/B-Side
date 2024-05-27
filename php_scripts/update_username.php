<?php
    include "connect_db.php";

    // update dello username
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();
        $username = $_SESSION["username"];

        if (isset($_POST["new_username"])) {
            $new_username = $_POST["new_username"];

            $conn = connect();
            // Controllo che non ci sia già un utente con lo stesso nome
            $stmt = $conn->prepare("SELECT COUNT(*) AS taken FROM user WHERE username = ?");
            $stmt->bind_param("s", $new_username);
            $stmt->execute();
            $isTaken = $stmt->get_result()->fetch_assoc()['taken'];

            if ($isTaken === 0) { 
                $stmt = $conn->prepare("UPDATE user SET username = ? WHERE username = ?");
                $stmt->bind_param("ss", $new_username, $username);

                $_SESSION["username"] = $new_username;

                if ($stmt->execute()) { // Si reinderizza alla "nuova" pagina profilo
                    header("Location: ../user.php?username=" . urlencode($_SESSION["username"]));
                }
            } else {
                echo "<div> The username is already taken </div>";
            }
            
            $conn->close();
        } else {
            echo "<div> There was an error trying to update the username </div>";
        }
    }
?>