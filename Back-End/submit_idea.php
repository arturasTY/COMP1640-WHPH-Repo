<?php 
session_start();

include 'includes/db_config.php';

   try {
        $result = $db_connection->query("SELECT * FROM Grp_Categories");
    }
    catch(PDOException $e) {
//        $output = "Error occured when adding author, please try again" . $e->getMessage();
//        include "error.html.php";
//        exit();
   }

   foreach ($result as $row) {
        $categories[] = array('CatID' => $row['CategoryID'], 'CatName' => $row['Categories']);
   }
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body class="bg-light">
   <?php include 'includes/nav.php'; ?>
    
    <div class="submit-idea-title">
        <div class="container">
            <h1>Submit an idea</h1>
            <p>Please complete all the required fields and adhere to <a href="#">rules and regulations</a> when submiting ideas.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form action="upload2.php" method="POST" enctype="multipart/form-data" id="submit-idea">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">Title</label>
                    <input name="Title" type="text" class="form-control" id="exampleFormControlInput1" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea class="form-control" name="Description" rows="5" required></textarea>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group cat">
                            <label for="exampleFormControlSelect1">Category</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="categ" required>
                              <?php foreach ($categories as $cat): ?>
                              <option value="<?php echo $cat['CatID']; ?>"><?php echo $cat['CatName']; ?></option>
                            <?php endforeach; ?>
                            </select>
                          </div>
                     </div>
                  </div>
                  <div class="row upload">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload File</label>
                            <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                          <input name="anon" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                            Post as anonymous
                          </label>
                        </div>
                    </div>
                  </div>
                 <div class="form-group" style="display: flex; align-items: baseline;">
                            <input type="checkbox" class="form-control" id="exampleFormControlInput1" required name="terms" style="width: auto; margin-right: 10px;">
                            <label for="exampleFormControlInput1">Agree to terms and conditions</label>
                        </div>
                  <input name="userid" type="hidden" value="<?php echo $_SESSION['emp_details']['empID']; ?>">
                  <input name="addform" type="submit" class="btn cta submit-idea">
                </form>
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
    
    
    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>