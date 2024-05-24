<?php
    session_start();

    if(isset($_SESSION["username"])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/login-register.css">
</head>
<body>
    <nav>
        <h1><a href="./" id = "navTitle">B-SIDE</a></h1>
        <h1><img id = "logo" src = "disc.png"></h1>
        <div id="search-div">
            <input type="text" placeholder="Cerca..." name="ricerca" id="ricerca">
            <div id="results"></div>
        </div>
        <div>
            <div id="user">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="" id="profile-image">
                <?php 
                    if(isset($_SESSION["username"])){
                        echo "<p>" . $_SESSION["username"] . "</p>";
                        echo "<a href=\"php_scripts/logout.php\">Logout</a>";
                    }else{
                        echo "<a href=\"login.php\">Login/Register</a>";
                    }
                ?>
            </div>
        </div>
    </nav>

    <div class="content">
        <h1>Login</h1>
        <form method="post">
            <label for="username">Username: </label>
            <input type="text" name="username">
            <label for="password">Password: </label>
            <input type="password" name="password">
            <input type="submit" value="Login">
        </form>

        <a id="register" href="register.php">Don't have an account yet? Register here</a>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            include "php_scripts/connect_db.php";
            $conn = connect();

            $username = $conn->real_escape_string($_POST["username"]);
            $password = $_POST["password"];

            if(empty($username) || empty($password)){
                die("Please fill in all fields");
            }

            $ris = $conn->query("SELECT password FROM User WHERE username = '$username'");

            if($ris->num_rows == 0){
                die("User not found");
            }else{
                if(password_verify($password, $ris->fetch_assoc()["password"])){
                    $_SESSION["username"] = $username;
                    echo "<script>window.location.href = 'index.php';</script>";
                }else{
                    die("Wrong password");
                }
            }
        }
    ?>
</body>
</html>