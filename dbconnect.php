<?php
    //database connection
    session_start();

    // Declare DB Variables
    $servername  = "localhost";
    $username = "root";
    $password = "";
    $dbname = "layout";

    /* Attempt to connect to MySQL database */
    try
    {
        $pdo = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname, $username, $password);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $GLOBALS['conn'] = $pdo;

    }
    catch(PDOException $e)
    {
        $GLOBALS['e'] = $e;
        die("ERROR: Could not connect. " . $e->getMessage());
    }

?>