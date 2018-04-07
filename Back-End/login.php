<?php 
session_start();
require "includes/db_config.php";
include_once "includes/helpers.inc.php";

$error = '';

if(isset($_POST['login'])) {

	$username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    $sql = "SELECT empID, Name, Email, DOB, LastLoginDate, Password FROM Grp_employee WHERE Name = :username";
    $statment = $db_connection->prepare($sql);
    $statment-> bindParam(':username', $username);
    $statment->execute();
    $results = $statment->fetch(PDO::FETCH_ASSOC);
    $empID = $results ['empID'];
    $currentdatetime = date('d-m-Y h:i:s');
    if(count($results) > 0 && $password == $results['Password'])
      
      {
        $sql = "UPDATE Grp_employee SET LastLoginDate = now() WHERE empID = $empID ";
        $statment = $db_connection->prepare($sql);
        $statment->execute();
        $emp_arr = array ('empID'=>$results['empID'],'username' => $results['Name'], 'email' => $results['Email'], 'DOB' => $results['DOB'], 'datetime' => $results['LastLoginDate']);
        $_SESSION['emp_details'] = $emp_arr;
        
        header("location: user_profile.php");
    
    } else {
    	$error .= "Incorrect Username or Password";
        include "includes/error.php";
        exit();
    }

}

?>

<!--
https://orca.gre.ac.uk/cas/login?service=https%3A%2F%2Fportal.gre.ac.uk%2Fc%2Fportal%2Flogin
https://moodlecurrent.gre.ac.uk/course/view.php?id=25599
https://mail.google.com/mail/u/0/#search/joe/161749b5eda75d44
http://stuweb.cms.gre.ac.uk/~ha07/web/PHP/
https://orca.gre.ac.uk/cas/login?service=https%3A%2F%2Fmoodlecurrent.gre.ac.uk%2Flogin%2Findex.php
http://ach-support.gre.ac.uk/unix/unixhomearea.html
http://stuweb.cms.gre.ac.uk/~sa725/COMP1640/user_profile.php
https://github.com/arturasTY/COMP1640-WHPH-Repo/blob/master/styles/style.css
http://stumyadmin.cms.gre.ac.uk/sql.php?server=1&db=mdb_br410&table=Grp_employee&pos=0
https://stackoverflow.com/questions/8812814/javascript-is-there-a-limit-to-else-if-statements
https://stackoverflow.com/questions/2427878/how-to-declare-more-than-one-header-on-php
https://www.w3schools.com/sql/sql_join.asp
https://www.google.co.uk/search?dcr=0&source=hp&ei=98enWsDGKtKiUqanhpAP&q=news&oq=news&gs_l=psy-ab.3..0i131k1l2j0j0i131k1l2j0i46k1j46l2j0j0i131k1j0l2.1479.1911.0.1957.5.4.0.0.0.0.126.275.2j1.3.0....0...1c.1.64.psy-ab..2.3.273.0...0.mgkpjAHuoWw
https://www.google.co.uk/search?rlz=1C1GCEA_enGB788GB788&ei=gc2nWr-1DajCgAaM9ojoBA&q=%21preg_match%28%27string%27&oq=%21preg_match%28%27string%27&gs_l=psy-ab.3..0i10i30k1j0i30k1j0i10i30k1l3j0i30k1j0i10i30k1l3j0i30k1.33614.34361.0.34559.6.6.0.0.0.0.81.433.6.6.0....0...1c.1.64.psy-ab..0.6.430...0i7i30k1.0.dEuKYUShKKA
https://stackoverflow.com/questions/23857052/preg-match-for-image-how-do-i-do-it
https://stackoverflow.com/questions/5613527/find-phrase-in-string-with-preg-match
https://stackoverflow.com/questions/13045279/if-isset-post
https://www.google.co.uk/search?q=optional+file+upload&rlz=1C1GCEA_enGB788GB788&oq=optional+file+upload&aqs=chrome..69i57j0l2.4599j0j7&sourceid=chrome&ie=UTF-8
https://stackoverflow.com/questions/16203396/how-to-submit-form-data-with-optional-upload-file
https://www.google.co.uk/search?q=not+set+php&rlz=1C1GCEA_enGB788GB788&oq=not+set+php&aqs=chrome..69i57j0l5.6783j0j7&sourceid=chrome&ie=UTF-8
https://stackoverflow.com/questions/7333404/if-isset-not-set-php
https://www.google.co.uk/search?rlz=1C1GCEA_enGB788GB788&ei=TOinWo_oEcaDgAa41KeADQ&q=easy+pagination+php&oq=easy+paganiation+&gs_l=psy-ab.3.1.0i13k1l4j0i13i30k1l6.106288.110865.0.114145.17.17.0.0.0.0.154.1182.15j2.17.0....0...1c.1.64.psy-ab..0.16.1081...0j0i131k1j0i67k1j0i10k1j0i22i30k1j0i22i10i30k1j33i160k1.0.BvQ1Bn8873w
http://www.w3programmers.com/simple-pagination-with-php-and-mysql/
https://code.tutsplus.com/tutorials/how-to-paginate-data-with-php--net-2928
http://stuweb.cms.gre.ac.uk/~sa725/coursework/recipes.php
https://www.w3schools.com/sql/sql_insert.asp
https://stackoverflow.com/questions/3144074/how-do-you-update-a-datetime-field-in-t-sql
http://php.net/manual/en/datetime.format.php
https://stackoverflow.com/questions/9760722/format-and-echo-datetime-string-received-from-mysql
https://chrome.google.com/webstore/detail/copy-all-urls/djdmadneanknadilpjiknlnanaolmbfk/related?hl=en
-->
