<?php

    $db_host="localhost";
    $db_user="root";
    $db_password="";
    $db_name="repicar";
  
    // Create connection
    $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
   
    mysqli_set_charset($db_connection, 'utf8');
     
    // Check connection
    if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
    }


?>