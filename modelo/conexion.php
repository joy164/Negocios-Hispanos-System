<?php
    $server="localhost";
    $user="root";
    $password="";
    $database="db_deal";
    
    $conn = new mysqli($server, $user, $password, $database);

    if(!$conn){
        echo"Error".PHP_EOL;
        exit;
    }
?>
