<?php

//this is the one we are using

require "includes/db_config.php";
$userid = $_POST['userid'];
$fna = explode('.', $_FILES['file']['name']);
$ext = $fna[count($fna)-1];
$heyu = $_POST['Title'];
$lol = $_POST['Description'];
$cateid = $_POST['categ'];
$terms = $_POST['terms'];

// check that we have an image file smaller than 4k bytes
//$_FILES['userFile']['tmp_name'];

if(!isset($terms)) {
    echo "you have to agree to terms";
    exit();
}



if (count($fna)>1) {
    


if (!preg_match('/gif|png|jpeg/', $_FILES['file']['type'])) {
   echo "<p><strong>Sorry, only browser compatible images allowedqweqweqweq</strong></p>";
} else if ( !preg_match('/gif|png|jpg|jpeg/', $ext) ) {

   echo "<p><strong>Sorry, only browser compatible images allowed\zx\zx\zx</strong></p>";
} else if ($_FILES['file']['size'] > 10000000 ) {
   echo "<p><strong>Sorry file too large</strong></p>";
// check we have a suitable name for the file
} 


else if ( strlen($_POST['Title']) < 3 ) {
   echo "<p><strong>Sorry userName too short<br />min 3 characters</strong></p>";
} else {
   // rename and copy the file to the uploads directory
   $filename = $_POST['Title'] . '.' . $ext;
   if ( copy($_FILES['file']['tmp_name'], "uploads/$filename") ) {
    
      
      if (chmod("uploads/$filename", 0664)) {
          
          if(isset($_POST['anon'])){
              $anon = true;
          }else {
              $anon = false;
          }
          
          $query = "INSERT INTO Grp_Ideas (FileUploads, IdeasText, Comments, CategoriesID, UserID, anonym) VALUES ('uploads/$filename', '$heyu' , '$lol', '$cateid', '$userid', '$anon')";
          $result = $db_connection->query($query);
          header("location: user_profile.php");
          
          $to      = 'sa725@gre.ac.uk';
            $subject = 'the subject';
            $message = 'New idea has been submitted!';
            $headers = 'From: webmaster@whph.co.uk' . "\r\n" .
                'Reply-To: admin@whph.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        exit;
          
      } 
         
       //header("location: user_profile.php");
       //
}
}

}

else{
    
        if(isset($_POST['anon'])){
              $anon = true;
          }else {
              $anon = false;
          }
           
          $query = "INSERT INTO Grp_Ideas (FileUploads, IdeasText, Comments, CategoriesID, UserID, anonym) VALUES ('No document uploaded', '$heyu' , '$lol', '$cateid', '$userid', '$anon')";
          $result = $db_connection->query($query);
    
          header("location: user_profile.php");
          
         $to      = 'sa725@gre.ac.uk';
                $subject = 'the subject';
                $message = 'New idea has been submitted!';
                $headers = 'From: webmaster@example.com' . "\r\n" .
                    'Reply-To: admin@whph.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            exit;
       }
?>