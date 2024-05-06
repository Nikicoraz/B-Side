<?php
    function grab_new_token(){
        function replace_existing_token($new_token){
            include "php_scripts/connect_db.php";

            $conn = connect();

            $q = $conn->query("SELECT token FROM Token");

            if($q->num_rows > 0){
                $conn->query("UPDATE Token SET token = '$new_token'");
            }else{
                $conn->query("INSERT INTO Token(token) VALUES('$new_token')");
            }
        }

        $env = parse_ini_file(".env");
    
        $curl = curl_init("https://accounts.spotify.com/api/token");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=" . $env["CLIENT_ID"] . "&client_secret=" . $env["CLIENT_SECRET"]);

        $result = json_decode(curl_exec($curl), true);

        replace_existing_token($result["access_token"]);
        return $result["access_token"];
    }

    function get_token(){
        include "php_scripts/connect_db.php";

        $conn = connect();
        $token = null;
        $q = $conn->query("SELECT token FROM Token");
        if($q->num_rows == 1){
            $token = $q->fetch_assoc()["token"];
        }else{
            $token = grab_new_token();
        }

        return $token;
    }
?>