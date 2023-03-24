<?php
    //database connection

    session_start();

    // Declare DB Variables
    $servername  = "localhost";
    $username = "root";
    $password = "";
    $dbname = "macaeblog";

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

    function includeWithVariables($filePath, $variables = array(), $print = true)
    {
        $output = NULL;
        if(file_exists($filePath))
        {
            // Extract the variables to a local namespace
            extract($variables);

            // Start output buffering
            ob_start();

            // Include the template file
            include $filePath;

            // End buffering and return its contents
            $output = ob_get_clean();
        }
        if ($print)
        {
            print $output;
        }
        return $output;
    }

?>