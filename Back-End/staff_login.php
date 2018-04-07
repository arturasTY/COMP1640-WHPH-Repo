<?php

session_start();
require "includes/db_config.php";
include_once "includes/helpers.inc.php";

$error = '';

if(isset($_POST['staff_login'])) {
    
    
	$username = test_input($_POST['staff_username']);
    $password = test_input($_POST['staff_password']);

    $sql = "SELECT * FROM Grp_Management WHERE mng_Name = :username";
    $statment = $db_connection->prepare($sql);
    $statment-> bindParam(':username', $username);
    $statment->execute();
    $results = $statment->fetch(PDO::FETCH_ASSOC);
    $staffID = $results['mng_Name'];
    $currentdatetime = date('d-m-Y h:i:s');
    
    if(count($results) > 0 && $password == $results['mng_password'])
      {

        $staff_arr = array ('id'=>$results['mng_id'],'pos' => $results['mng_position'], 'name' => $results['mng_Name']);
       $_SESSION['staff_details'] = $staff_arr;
        header("Location: admin/index.php");
        

    
    } else {
    	$error .= "Incorrect Username or Password";
        include "includes/error.php";
        exit();
    }

}

?>

