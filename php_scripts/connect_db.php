<?php
    function connect(){
        $conn = new mysqli("127.0.0.1", "root", "changeme", "bside");
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
?>