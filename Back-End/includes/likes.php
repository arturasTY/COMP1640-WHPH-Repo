<?php

session_start();
// connect to database
$conn = mysqli_connect('mysql.cms.gre.ac.uk', 'br410', 'minig22W', 'mdb_br410');

// lets assume a user is logged in with id $user_id
if(isset($_SESSION['emp_details'])) {
    $user_id = $_SESSION['emp_details']['empID'];
} else {
    $user_id = null;
}


if (!$conn) {
  die("Error connecting to database: " . mysqli_connect_error($conn));
  exit();
}

// if user clicks like or dislike button
if (isset($_POST['action']) && isset($_SESSION['emp_details'])) {
  //$user_id = 1;
  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'like':
         $sql="INSERT INTO Grp_Likes (user_id, post_id, Likes_dislikes)
         	   VALUES ($user_id, $post_id, 'like')
         	   ON DUPLICATE KEY UPDATE Likes_dislikes ='like'";
         break;
  	case 'dislike':
          $sql="INSERT INTO Grp_Likes (user_id, post_id, Likes_dislikes)
               VALUES ($user_id, $post_id, 'dislike')
         	   ON DUPLICATE KEY UPDATE Likes_dislikes ='dislike'";
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
  mysqli_query($conn, $sql);
  echo getRating($post_id);
  exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM Grp_Likes
  		  WHERE post_id = $id AND Likes_dislikes ='like'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM Grp_Likes
  		  WHERE post_id = $id AND Likes_dislikes ='dislike'";
  $rs = mysqli_query($conn, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
  global $conn;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM Grp_Likes WHERE post_id = $id AND Likes_dislikes ='like'";
  $dislikes_query = "SELECT COUNT(*) FROM Grp_Likes
		  			WHERE post_id = $id AND Likes_dislikes ='dislike'";
  $likes_rs = mysqli_query($conn, $likes_query);
  $dislikes_rs = mysqli_query($conn, $dislikes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $dislikes = mysqli_fetch_array($dislikes_rs);
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  global $conn;
  //global $user_id;
  $sql = "SELECT * FROM Grp_Likes WHERE post_id=$post_id AND Likes_dislikes='like'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}

// Check if user already dislikes post or not
function userDisliked($post_id)
{
  global $conn;
  //global $user_id;
  $sql = "SELECT * FROM Grp_Likes WHERE post_id=$post_id AND Likes_dislikes='dislike'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}