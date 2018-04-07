<?php 
// connect to database
require "includes/db_config.php";
include_once "includes/helpers.inc.php";

// lets assume a user is logged in with id $user_id
$user_id = 1;

// if user clicks like or dislike button
if (isset($_POST['action'])) {
  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'like':
         $sql="INSERT INTO Grp_Likes (user_id, post_id, Likes_dislikes) 
         	   VALUES ($user_id, $post_id, 'like') 
         	   ON DUPLICATE KEY UPDATE rating_action='like'";
         break;
  	case 'dislike':
          $sql="INSERT INTO Grp_Likes (user_id, post_id, Likes_dislikes) 
               VALUES ($user_id, $post_id, 'dislike') 
         	   ON DUPLICATE KEY UPDATE rating_action='dislike'";
         break;
  	case 'unlike':
	      $sql="DELETE FROM Grp_Likes WHERE user_id=$user_id AND post_id=$post_id";
	      break;
  	case 'undislike':
      	  $sql="DELETE FROM Grp_Likes WHERE user_id=$user_id AND post_id=$post_id";
      break;
  	default:
  		break;
  }

  // execute query to effect changes in the database ...
    $statment = $db_connection->prepare($sql);
    $statment->execute();
/*  mysqli_query($conn, $sql);*/
  echo getRating($post_id);
  exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM Grp_Likes
  		  WHERE post_id = $id AND Likes_dislikes ='like'";
    
$statment = $db_connection->prepare($sql);
$statment->execute();
$results = $statment->fetch(PDO::FETCH_ASSOC);    
return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{

  $sql = "SELECT COUNT(*) FROM Grp_Likes 
  		  WHERE post_id = $id AND Likes_dislikes ='dislike'";
    
$statment = $db_connection->prepare($sql);
$statment->execute();
$results = $statment->fetch(PDO::FETCH_ASSOC);  
  return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{

  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM Grp_Likes WHERE post_id = $id AND Likes_dislikes ='like'";
  $dislikes_query = "SELECT COUNT(*) FROM Grp_Likes
		  			WHERE post_id = $id AND Likes_dislikes ='dislike'";
    
$likers = $db_connection->prepare($likes_query);
$statment->execute();
    
$dislikers = $db_connection->prepare($dislikes_query);
$statment->execute();  
    
$resultslikes = $likers->fetch(PDO::FETCH_ASSOC);
$resultsdislikes = $dislikers->fetch(PDO::FETCH_ASSOC); 
    $rating = [
  	'likes' => $resultslikes[0],
  	'dislikes' => $resultsdislikes[0]
  ];
  return json_encode($rating);
} 

// Check if user already likes post or not
function userLiked($post_id)
{

  global $user_id;
  $sql = "SELECT * FROM Grp_Likes WHERE user_id=$user_id 
  		  AND post_id=$post_id AND Likes_dislikes='like'";
$statment = $db_connection->prepare($sql);
$statment->execute();
  if (count($statment) > 0 ) {
  	return true;
  }else{
  	return false;
  }
}

// Check if user already dislikes post or not
function userDisliked($post_id)
{

  global $user_id;
  $sql = "SELECT * FROM Grp_Likes WHERE user_id=$user_id 
  		  AND post_id=$post_id AND Likes_dislikes='dislike'";
$statment = $db_connection->prepare($sql);
$statment->execute();
  if (count($statment) > 0 ) {
  	return true;
  }else{
  	return false;
  }
}

$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
// fetch all posts from database
// return them as an associative array called $posts
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);