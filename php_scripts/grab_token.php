<?php

    function grabNewToken(){
        $env = parse_ini_file(".env");
    
        $curl = curl_init("https://accounts.spotify.com/api/token");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=" . $env["CLIENT_ID"] . "&client_secret=" . $env["CLIENT_SECRET"]);

        $result = json_decode(curl_exec($curl), true);

        return $result["access_token"];
    }


?>