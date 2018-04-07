<?php

$db_host = "mysql.cms.gre.ac.uk";
$db_username = "br410";
$db_password = "minig22W";
$db_name = "mdb_br410";

try {
    $db_connection = new PDO("mysql:host=$db_host; dbname=$db_name", $db_username, $db_password);
    
   
    // set the PDO error mode to exception
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch(PDOException $e){
    
    echo "Connection Failed: " . $e->getMessage();
}

?>