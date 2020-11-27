<?php

    $servername = "localhost";
    $database = "baraya";
    $userdb = "root";
    $passworddb = "";
    // $passworddb = "InovasiBaraya!@";
    
    
    $conn = new mysqli($servername, $userdb, $passworddb, $database);
    
    if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
    }
    
?>