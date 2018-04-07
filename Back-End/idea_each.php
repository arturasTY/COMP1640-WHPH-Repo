<?php 
//session_start();
include "includes/likes.php";
require "includes/db_config.php";

if(isset($_SESSION['emp_details'])) {
    $user_id = $_SESSION['emp_details']['empID'];
} else {
    $user_id = null;
}
//$userid = $_SESSION['emp_details']['empID'];
//$username = $_SESSION['emp_details']['username'];



$id = $_GET['id'];
try {
        $result = $db_connection->query("SELECT Grp_Ideas.IdeasID, IdeasText, Comments, Grp_Ideas.UserID, views, anonym, Grp_employee.Name FROM Grp_Ideas INNER JOIN Grp_employee ON Grp_Ideas.UserID = Grp_employee.empID WHERE IdeasID = $id");
        $views = $db_connection->query("UPDATE Grp_Ideas SET `views` = `views`+1 WHERE IdeasID = $id");
        $v = $db_connection->query("SELECT views FROM Grp_Ideas WHERE IdeasID = $id");


    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($result as $row) {
        $ideas[] = array('Id' => $row['IdeasID'], 'ideastext' => $row['IdeasText'], 'ideacomment' => $row['Comments'], 'userId' => $row['UserID'], 'view' => $row['views'], 'anon' => $row['anonym'], 'username' => $row['Name'] );
   }

    foreach ($v as $view) {
        $vi[] = array('count' => $view['views']);
   }





// foreach ($us as $user) {
//        
//   }


   try {
       $result = $db_connection->query("SELECT Grp_Comments.CommentsID, Grp_Comments.EmpID, CommentsText, anonym, idea_ID, Name FROM Grp_Comments INNER JOIN Grp_employee ON Grp_Comments.EmpID = Grp_employee.empID WHERE idea_ID = $id LIMIT 5");
   }
    catch(PDOException $e) {
        
    }

    foreach ($result as $comment) {
       $comments[] = array('id' => $comment['CommentsID'], 'ideastext' => $comment['EmpID'], 'ideacomment' => $comment['CommentsText'], 'anonymo' => $comment['anonym'], 'username' => $comment['Name']);
    }
    
    if(isset($_POST['add']) && isset($_SESSION['emp_details'])) {
        
        if(isset($_POST['anon'])){
              $anon = true;
          }else {
              $anon = false;
          }
        
    try {
        $sql = "INSERT INTO Grp_Comments (EmpID, CommentsText, anonym, idea_ID) VALUES(:emp, :comm, :anonymo, :ide)";
        $s = $db_connection->prepare($sql);
        $s->bindValue(':emp', $user_id);
        $s->bindValue(':ide', $id);
        $s->bindValue(':comm', $_POST['comment_text'] );
        $s->bindValue(':anonymo', $anon );

        $s->execute();
        header("location: idea_each.php?id=". $row['IdeasID']);
        
        $to      = 'sa725@gre.ac.uk';
        $subject = 'the subject';
        $message = 'Someone has just commented on your idea!';
        $headers = 'From: webmaster@whph.co.uk' . "\r\n" .
            'Reply-To: admin@whph.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        exit;
        

    } catch (PDOException $e) {
        //$output = "Error occured when adding author, please try again" . $e->getMessage();
        //exit();
    }
  }




?>


<!DOCTYPE html>
<html lang="en">

    <?php include 'includes/head.php'; ?>
    
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark-1 text-dark" style="box-shadow: none;">
        <div class="container">
        <a href="index.php" class="navbar-brand logo"><span>W.H.P.H</span></a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>

                <li class="nav-item">
                    <a href="about.php" class="nav-link">About</a>
                </li>

                <li class="nav-item">
                    <a href="ideas.php" class="nav-link">Ideas</a>
                </li>
                <?php if(isset($_SESSION['emp_details'])): ?>
                    <li class="nav-item">
                        <a href="submit_idea.php" class="nav-link">Submit Idea</a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <?php if(isset($_SESSION['emp_details']['username'])): ?>
            
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter"><?php echo $_SESSION['emp_details']['username']; ?></a>

            
            <?php else: ?>
            
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter">Sign in</a>
            
            <?php endif; ?>
            <a class="btn btn-outline cta" href="#" data-toggle="modal" data-target="#exampleModalCenter">Staff</a>
        </div>
        </div>
    </nav> <!--end of main nav -->
<!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
           <div class="text-block">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Your Comment</h5>
           </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="comment">
              <div class="form-group">
                <label for="exampleInputEmail1">Comment </label>
                <span class="error">Username is required</span>

                <textarea name="comment_text" class="form-control"></textarea>
              </div>
                 <div class="form-check">
                          <input name="anon" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                            Post as anonymous
                          </label>
                        </div>
              <input type="submit" class="btn mybtn w-100" value="Submit" name="add">
            </form>
          </div>
        </div><!-- end of modal-content -->
      </div>
    </div> <!-- end of modal -->
    
    <section class="user-profile">
        <div class="container">
            <?php if(!empty($_GET['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message = $_GET['message']; ?>
            </div>
            <?php endif; ?>
            <div class="profile-block">
                <div class="user-ideas-each">
                    <h4><a href="javascript:history.back(1)" class="btn btn-light">Go Back</a></h4>
                        <div class="card idea-each" style="height: auto;">
                            <div class="card-body">
                                <div class="top-text">
                                    <h5><a href="#"></a><?php echo $row['IdeasText']; ?></h5>
                                </div>
                                <div class="idea-body">
                                    <?php echo $row['Comments']; ?>
                                </div>
                                <div class="coll">
                                    <div class="thumb-block">
                                     <span><i
                                  <?php if (userLiked($row['IdeasID'])): ?>
                                      class="fa fa-thumbs-up like-btn"
                                  <?php else: ?>
                                      class="fa fa-thumbs-o-up like-btn"
                                  <?php endif ?>
                                  data-id="<?php echo $row['IdeasID'] ?>"></i>
                                            <span class="likes"><?php echo getLikes($row['IdeasID']); ?></span>
                                        </span>


                                        <span>
                                           <i
                                  <?php if (userDisliked($row['IdeasID'])): ?>
                                      class="fa fa-thumbs-down dislike-btn"
                                  <?php else: ?>
                                      class="fa fa-thumbs-o-down dislike-btn"
                                  <?php endif ?>
                                  data-id="<?php echo $row['IdeasID'] ?>"></i>
                                            <span class="dislikes"><?php echo getDislikes($row['IdeasID']); ?></span>
                                        </span>
                                    </div>
                                    <div class="comment-block">
                                        <?php if($row['anonym'] == true): ?>
                                        
                                        <span>posted by: Anonymous</span>
                                        
                                        <?php else: ?>
            
                                        <span>posted by: <?php echo $row['Name']; ?></span>
            
                                        <?php endif; ?>
                                        <span><i class="ion-eye">&nbsp;</i><?php echo $view['views']; ?></span>
                                    </div>
                                </div>
                                <?php if(isset($_SESSION['emp_details'])): ?>
                                    <a class="btn btn-outline cta" style="margin-left: 0px; width: 100%;" href="#" data-toggle="modal" data-target="#exampleModalCenter">Add Comment</a>
                                <?php else: ?>
                                   <a class="btn btn-outline cta disabled" style="margin-left: 0px; width: 100%;" href="#" data-toggle="modal" data-target="#exampleModalCenter">Please Login to comment</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    
                    <h4>Comments</h4>
                    <?php if(isset($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="card comments" style="height: auto;">
                                <div class="card-body">
                                    <p><?php echo $comment['ideacomment']; ?></p>
                                    <br>
                                    <?php if($comment['anonymo'] == true): ?>

                                            <span>posted by: Anonymous</span>

                                            <?php else: ?>

                                            <span>posted by: <?php echo $comment['username']; ?></span>

                                            <?php endif; ?>
                                    <form class="<?=$_SERVER['PHP_SELF'];?>" method="post">
                                        <input type="hidden" name="bel" value="<?php echo $comment['id']; ?>">
                                    </form>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                    
                        
                            <p>There are no comments for this idea!</p>
                     
                    </div>
                    <?php endif; ?>
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




    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

</body>
</html>