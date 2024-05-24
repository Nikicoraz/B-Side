<?php
    /**
     * Generates a new Spotify API token and stores it in the database
     * @return string The new Spotify API token
     */
    function grab_new_token(){
        /**
         * Replaces the existing token in the database with the new one
         * @param string $new_token The new token to be stored in the database
         */
        function replace_existing_token($new_token){
            include_once "php_scripts/connect_db.php";

            $conn = connect();

            $q = $conn->query("SELECT token FROM Token");

            if($q->num_rows > 0){
                $conn->query("UPDATE Token SET token = '$new_token'");
            }else{
                $conn->query("INSERT INTO Token(token) VALUES('$new_token')");
            }
        }

        $env = parse_ini_file(dirname(__FILE__) . "/../.env");

        $curl = curl_init("https://accounts.spotify.com/api/token");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=" . $env["CLIENT_ID"] . "&client_secret=" . $env["CLIENT_SECRET"]);

        $result = json_decode(curl_exec($curl), true);

        replace_existing_token($result["access_token"]);
        return $result["access_token"];
    }


    /**
     * Gets the Spotify API token from the database if it exists, otherwise it
     * generates a new one and stores it in the database
     * @return string The Spotify API token
     */
    function get_token(){
        include dirname(__FILE__) . "/connect_db.php";

        $conn = connect();
        $token = null;

        // Query the database for the token
        $q = $conn->query("SELECT token FROM Token");

        // If the token exists in the database
        if($q->num_rows == 1){
            // Get the token from the database and return it
            $token = $q->fetch_assoc()["token"];
        }else{
            // If the token does not exist in the database, generate a new one
            // and store it in the database
            $token = grab_new_token();
        }

        return $token;
    }
?>