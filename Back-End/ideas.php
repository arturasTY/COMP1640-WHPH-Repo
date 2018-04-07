<?php
include "includes/db_config.php";
include "includes/likes.php";
//session_start();

// This first query is just to get the total count of rows
$sql = "SELECT COUNT(IdeasID) FROM Grp_Ideas";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_row($query);


// Here we have the total row count
$rows = $row[0];
// This is the number of results we want displayed per page
$page_rows = 5;
// This tells us the page number of our last page
$last = ceil($rows/$page_rows);
// This makes sure $last cannot be less than 1
if($last < 1){
	$last = 1;
}
// Establish the $pagenum variable
$pagenum = 1;
// Get pagenum from URL vars if it is present, else it is = 1
if(isset($_GET['pn'])){
	$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
}
// This makes sure the page number isn't below 1, or more than our $last page
if ($pagenum < 1) { 
    $pagenum = 1; 
} else if ($pagenum > $last) { 
    $pagenum = $last; 
}
// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

$sql = "SELECT Grp_Ideas.IdeasID, IdeasText, Comments, Grp_Ideas.UserID, views, anonym, Grp_employee.Name FROM Grp_Ideas INNER JOIN Grp_employee ON Grp_Ideas.UserID = Grp_employee.empID ORDER BY IdeasID DESC $limit";
$result = mysqli_query($conn, $sql);
// fetch all posts from database
// return them as an associative array called $posts
$ideas = mysqli_fetch_all($result, MYSQLI_ASSOC);

//$id = $_POST['post_id'];


//foreach ($result as $row) {
//        $ideas[] = array('Id' => $row['IdeasID'], 'ideastext' => $row['IdeasText'], 'ideacomment' => $row['Comments']);
//   }

$paginationCtrls = '';
// If there is more than 1 page worth of results
if($last != 1){
	/* First we check if we are on page one. If we are then we don't need a link to 
	   the previous page or the first page so we do nothing. If we aren't then we
	   generate links to the first page, and to the previous page. */
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp; ';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
			}
	    }
    }
	// Render the target page number, but without it being a link
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}
	// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> ';
    }
}


try {
        $views = $db_connection->query("SELECT IdeasID, IdeasText, views AS views FROM Grp_Ideas GROUP BY views ORDER BY views DESC LIMIT 3");
    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($views as $row) {
        $view[] = array('Id' => $row['IdeasID'], 'ideastext' => $row['IdeasText'], 'views' => $row['views']);
   }

try {
        $pop = $db_connection->query("SELECT Post_id, Grp_Ideas.IdeasID, Grp_Ideas.IdeasText, Grp_employee.Name, COUNT(Likes_dislikes) AS value_occurrence FROM `Grp_Likes` INNER JOIN Grp_Ideas ON Grp_Likes.Post_id = Grp_Ideas.IdeasID INNER JOIN Grp_employee ON Grp_Ideas.UserID = Grp_employee.empID GROUP BY Post_id ORDER BY value_occurrence DESC LIMIT 3");
    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($pop as $row) {
        $pops[] = array('Id' => $row['Post_id'], 'ideaid' => $row['IdeasID'], 'ideastext' => $row['IdeasText'], 'popular' => $row['value_occurrence'], 'user' => $row['Name']);
   }
    
   try {
        $latest = $db_connection->query("SELECT IdeasID, IdeasText, views FROM Grp_Ideas ORDER BY IdeasID DESC LIMIT 3");
    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($latest as $row) {
        $lates[] = array('Id' => $row['IdeasID'], 'ideastext' => $row['IdeasText'], 'views' => $row['views']);
   }
   

    if(isset($_POST['flag']) && isset($_SESSION['emp_details'])){
            $ide = $_POST['ide'];
            $by = $_POST['by'];
            
            $to = 'sa725@gre.ac.uk';
            $subject = 'Inappropriate idea posted by user: ' . $by ;
            $inna = "<span style='color: red;'>INAPPROPRIATE.</span>";
            $message = "To Administrator Attention, <br/>" . 'Idea: '. "<b>".$ide."</b>" .' has been flagged as '. $inna;
            $headers = 'From: webmaster@whph.co.uk' . "\r\n" .
                'Reply-To: admin@whph.com' . "\r\n" .
                'Content-Type: text/html; charset=ISO-8859-1\r\n'.
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            header("location: ideas.php?message=Idea has been flagged as Inappropriate");
    }

?>



<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body class="bg-light">

    <?php include 'includes/header.php'; ?>


    <div class="nav-scroller bg-white box-shadow" style="box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, .05);">
         <div class="container">
              <nav class="nav nav-underline">
                <a class="nav-link active" href="#">Latest</a>
                <a class="nav-link" href="#">
                  New
                  <span class="badge badge-pill bg-light align-text-bottom">27</span>
                </a>
                <a class="nav-link" href="#">Most Popular</a>
                <a class="nav-link" href="#">Most Viewed</a>
              </nav>
          </div>
    </div>
    <div class="container" style="margin-top: 30px; margin-bottom: 60px;">
        <?php if(!empty($_GET['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message = $_GET['message']; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-8">
                 <?php foreach ($ideas as $idea): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="avatar"></div>
                        <div class="top-text">
                            <h5><a href="idea_each.php?id=<?php echo $idea['IdeasID']; ?>"><?php echo $idea['IdeasText']; ?></a></h5>
                        </div>
                        <div class="thumb-block">

                            <span><i
					  <?php if (userLiked($idea['IdeasID'])): ?>
						  class="fa fa-thumbs-up like-btn"
					  <?php else: ?>
						  class="fa fa-thumbs-o-up like-btn"
					  <?php endif ?>
					  data-id="<?php echo $idea['IdeasID'] ?>"></i>
                                <span class="likes"><?php echo getLikes($idea['IdeasID']); ?></span>
                            </span>


                            <span>
                               <i
					  <?php if (userDisliked($idea['IdeasID'])): ?>
						  class="fa fa-thumbs-down dislike-btn"
					  <?php else: ?>
						  class="fa fa-thumbs-o-down dislike-btn"
					  <?php endif ?>
					  data-id="<?php echo $idea['IdeasID'] ?>"></i>
                                <span class="dislikes"><?php echo getDislikes($idea['IdeasID']); ?></span>
                            </span>


                        </div>
                        <div class="comment-block">
                            <span>
                                <i class="ion-ios-chatbubble"></i>
                                <?php
                                    $id = $idea['IdeasID'];
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
                            <?php if($idea['anonym'] == true): ?>
                                        
                            <span>posted by: Anonymous</span>

                            <?php else: ?>

                            <span>posted by: <?php echo $idea['Name'];  ?></span>

                            <?php endif; ?>
                            
                            
                        </div>
                        <div class="flag">
                            <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                                <input type="hidden" name="ide" value="<?php echo $idea['IdeasText']; ?>">
                                <input type="hidden" name="by" value="<?php echo $idea['Name']; ?>">
                               <button type="submit" name="flag"><span><i class="ion-flag"></i>Flag as inappropriate</span></button>
                            </form>
                           
                        </div>
                    </div>
                    <input name="id" type="hidden" value="<?php echo $idea['IdeasID']; ?>"> 
                </div>
                    <?php endforeach ?>
                  <div id="pagination_controls"><?php echo $paginationCtrls; ?></div>

            </div>

            <div class="col-md-4">
                <div class="card hy">
                    <div class="card-body">
                       <div class="top-users">
                         <h5>Latest Ideas</h5>
                         <?php foreach ($lates as $late): ?>
                             <div class="user-2">
                                <div class="top-user-name">
                                    <span><a href="idea_each.php?id=<?php echo $late['Id']; ?>"><?php echo $late['ideastext']; ?></a></span><br>
                                </div>
                             </div>
                         <?php endforeach ?>
                       </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                       <div class="top-users">
                            <h5>Most Popular Ideas</h5>
                           <?php foreach ($pops as $pop): ?>
                            <div class="user-1">
                                <div class="avatar"></div>
                                <div class="top-user-name">
                                    <span><a href="idea_each.php?id=<?php echo $pop['ideaid']; ?>"><?php echo $pop['ideastext']; ?></a></span><br>
                                    <span><?php echo $pop['user']; ?></span>
                                </div>
                                <div class="ideas-number">
                                    <span> <?php echo $pop['popular']; ?> Likes</span>
                                </div>
                            </div>
                           <?php endforeach ?>
                       </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                      <div class="top-users">
                       <div class="top-level">
                           <h5>Most Viewed Ideas</h5>
                       </div>
                          <?php foreach ($view as $each): ?>
                         <div class="idea-1">
                            <span class="most-view"><i class="ion-eye"></i> <?php echo $each['views']; ?> Views</span>
                            <div class="idea-name">
                                <a href="#"><?php echo $each['ideastext']; ?></a><br>
                            </div>
                        </div>
                          <?php endforeach ?>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        setTimeout(function() {
          $('.alert').remove();
            window.history.replaceState(null, null, window.location.pathname);
        }, 2000);
        
    </script>
</body>
</html>
