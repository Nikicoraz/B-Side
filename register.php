<?php
    session_start();
    if(isset($_SESSION["username"])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/comune.css">
    <link rel="stylesheet" href="css/login-register.css">
</head>
<body>
    <nav>
        <h1><a href="./">B-SIDE</a></h1>
        <div id="search-div">
            <input type="text" placeholder="Cerca..." name="ricerca" id="ricerca">
            <div id="results"></div>
        </div>
        <div>
            <div id="user">
                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png" alt="" id="profile-image">
                <!-- <p>Username</p> -->
                <a href="login.php">Login/Register</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <h1>Register</h1>
        <form method="POST">
            <label for="username">Username: </label>
            <input type="text" name="username" required>
            <label for="password">Password: </label>
            <input type="password" name="password" required minlength="6">
            <label for="bio">Bio: </label>
            <textarea name="bio" required minlength="10" placeholder="Tell us a bit about yourself..."></textarea>
            <input type="submit" value="Register">
        </form>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            include "php_scripts/connect_db.php";
            $conn = connect();

            $username = $conn->real_escape_string($_POST["username"]);
            $password = $_POST["password"];
            $bio = $conn->real_escape_string($_POST["bio"]);
    
            if(empty($username) || empty($password) || empty($bio)){
                die("Please fill in all fields");
            }

            if(strlen($password) < 6){
                die("Password must be at least 6 characters long");
            }

            if(strlen($bio) < 10){
                die("Bio must be at least 10 characters long");
            }

            if($conn->query("SELECT username from User WHERE username = '$username'")->num_rows > 0){
                die("Username already exists");
            }else{
                $password = password_hash($password, PASSWORD_DEFAULT);

                if($conn->query("INSERT INTO User (username, password, bio) VALUES ('$username', '$password', '$bio')")){
                    $_SESSION["username"] = $username;
                    echo "<script>window.location = 'index.php'</script>";
                }else{
                    die("Error: " . $conn->error);
                }
            }
        }
    ?>
</body>
</html>