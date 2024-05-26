<?php
    /**
     * Connect to the MySQL database
     *
     * @return mysqli connection object
     */
    function connect(){
        // Connect to the database
        $env = parse_ini_file(dirname(__FILE__) . "/../.env");
        $conn = new mysqli($env['DB_URL'], $env["DB_USER"], $env["DB_PASS"], $env["DB_NAME"]);
        // If connection fails, stop the script
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        // Return the connection object
        return $conn;
    }

?>