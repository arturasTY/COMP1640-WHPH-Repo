<?php 
//session_start();
require "includes/db_config.php";
include "includes/likes.php";

if(!isset($_SESSION['emp_details'])) {
    header("location: index.php");
} else {
    $user_id = $_SESSION['emp_details']['empID'];
}
$userid = $_SESSION['emp_details']['empID'];


try {
        $result = $db_connection->query("SELECT * FROM Grp_Ideas WHERE UserID = $userid ORDER BY IdeasID DESC LIMIT 5");
    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($result as $row) {
        $ideas[] = array('Id' => $row['IdeasID'], 'ideastext' => $row['IdeasText'], 'ideacomment' => $row['Comments'], 'views' => $row['views']);
   }


$var = $_SESSION['emp_details']['datetime'];

$date= date_create($var);
$time = date_format($date, "d/m/Y H:i:s");

?>


<!DOCTYPE html>
<html lang="en">

    <?php include 'includes/head.php'; ?>
    
<body>

<?php include 'includes/nav.php'; ?>

    <section class="user-profile">
        <div class="container">
            <div class="profile-block">
                <div class="user-details-each">
                    <div class="username">
                        <div class="avatar"></div>
                        <h3><?php echo $_SESSION['emp_details']['username']; ?></h3>
                        <div class="details">
                            <p><i class="ion-email"></i><?php echo $_SESSION['emp_details']['email']; ?></p>
                            <p><i class="ion-ios-home"></i>IT Department</p>
                        </div>
                        <p class="last-login"><i class="ion-log-in"></i>You last logged in on <?php echo $time;  ?></p>
                    </div>
                <a href="logout.php" class="btn mybtn cta">Logout</a>
                </div>

                <div class="user-ideas-each">
                    <h4>Your Ideas</h4>
                    <?php foreach ($ideas as $idea): ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="top-text">
                                    <h5><a href="idea_each.php?id=<?php echo $idea['Id']; ?>"><?php echo $idea['ideastext']; ?></a></h5>
                                </div>
                                <div class="thumb-block">
                                              <span><i
                                  <?php if (userLiked($idea['Id'])): ?>
                                      class="fa fa-thumbs-up like-btn"
                                  <?php else: ?>
                                      class="fa fa-thumbs-o-up like-btn"
                                  <?php endif ?>
                                  data-id="<?php echo $idea['Id'] ?>"></i>
                                            <span class="likes"><?php echo getLikes($idea['Id']); ?></span>
                                        </span>


                                        <span>
                                           <i
                                  <?php if (userDisliked($idea['Id'])): ?>
                                      class="fa fa-thumbs-down dislike-btn"
                                  <?php else: ?>
                                      class="fa fa-thumbs-o-down dislike-btn"
                                  <?php endif ?>
                                  data-id="<?php echo $idea['Id'] ?>"></i>
                                            <span class="dislikes"><?php echo getDislikes($idea['Id']); ?></span>
                                        </span>
                                </div>
                                <div class="comment-block">
                                    <span>
                                        <i class="ion-ios-chatbubble"></i>
                                        <?php
                                            $id = $idea['Id'];
                                            $sql = "SELECT * FROM Grp_Comments WHERE idea_ID = $id";
                                            //$query = mysqli_query($conn, $sql);

                                            if ($result=mysqli_query($conn,$sql))
                                              {
                                              // Return the number of rows in result set
                                              $rowcount=mysqli_num_rows($result);
                                              //printf("Result set has %d rows.\n",$rowcount);
                                              // Free result set
                                              mysqli_free_result($result);
                                              }
                                            echo $rowcount . ' Comments';
                                        ?>
                                    </span>
                                    <span><i class="ion-eye"></i> <?php echo $idea['views']; ?> Views</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </section>
<footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#"><i class="ion-arrow-up-c"></i>Back to top</a>
        </p>
        <p>&copy; Copyright 2018 Team - Work Hard Play Hard. All Rights Reserved</p>
        <p>New to WHPH? <a href="index.html">Visit the homepage</a></p>
      </div>
    </footer>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

</body>
</html>