<?php

if(isset($_POST["download"]))  
 {  
      $conn = mysqli_connect('mysql.cms.gre.ac.uk', 'br410', 'minig22W', 'mdb_br410'); 
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('Idea ID', 'Idea Title', 'Idea Body', 'Author', 'Total Views'));  
      $query = "SELECT IdeasID, IdeasText, Comments, UserID, views from Grp_Ideas";  
      $result = mysqli_query($conn, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }

?>