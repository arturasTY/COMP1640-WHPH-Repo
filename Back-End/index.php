<?php
session_start();
include "includes/db_config.php";

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<body>
    
    <?php include 'includes/header.php'; ?>

    <section class="landing">
        <div class="container">
           <div class="row">
               <div class="col-md-6">
                    <h1 class="idea-lead">Share Ideas</h1>
                    <h3 class="idea-sublead">A New approach to idea management.</h3>
                    <ul class="common-btns">
                        <li><a href="#" class="common-Button" data-toggle="modal" data-target="#exampleModalCenter">Sign In</a></li>
                        <li><span class="help-center">OR</span></li>
                        <li><a href="#" class="common-Button">Read More</a></li>
                    </ul>
               </div>
               
               <div class="col-md-6">
                   <img src="images/banner-img-3.png" alt="" id="phone" class="img-fluid">
               </div>
           </div>
            
        </div>
    </section>
    
    
    
    
    
    
    
    
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<?php if(isset($script)){ echo $script; } ?>
</body>
</html>