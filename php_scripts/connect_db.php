<?php
    /**
     * Connect to the MySQL database
     *
     * @return mysqli connection object
     */
    function connect(){
        // Connect to the database
        $conn = new mysqli("127.0.0.1", "root", "changeme", "bside");
        // If connection fails, stop the script
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        // Return the connection object
        return $conn;
    }

?>