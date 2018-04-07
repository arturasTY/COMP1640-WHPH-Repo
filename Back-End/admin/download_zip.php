<?php
require "../includes/db_config.php";

if(isset($_POST['download']))  
 { 
    $dir = '../uploads';
    
    $zip_file = 'file.zip';

    // Get real path for our folder
    $rootPath = realpath($dir);
    //die($rootPath);
    // Initialize archive object
    $zip = new ZipArchive();
    $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    //$zip->close();


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($zip_file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zip_file));
    readfile($zip_file);
    
    
//    $files = array('image.jpeg','text.txt','music.wav');
//    $zipname = 'enter_any_name_for_the_zipped_file.zip';
//    $zip = new ZipArchive;
//    $zip->open($zipname, ZipArchive::CREATE);
//    foreach ($files as $file) {
//      $zip->addFile($file);
//    }
//    $zip->close();
//
//    ///Then download the zipped file.
//    header('Content-Type: application/zip');
//    header('Content-disposition: attachment; filename='.$zipname);
//    header('Content-Length: ' . filesize($zipname));
//    readfile($zipname);
//    unlink($zipname);
//    exit;
//      $post = $_POST;
//
//    $f = 'ARNOLD.png';
//      $file_folder = "uploads/beirk.php"; // folder to load files  
//      if(extension_loaded('zip'))  
//      {   
//           // Checking ZIP extension is available    
//        // Checking files are selected  
//        $zip = new ZipArchive(); // Load zip library   
//        $zip_name = "Users_data".".zip";           // Zip name  
//        if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)  
//        {   
//             // Opening zip file to load files  
//             echo "* Sorry ZIP creation failed at this time";  
//        }  
////        foreach($files_to_zip as $file)  
////        {   
//             $zip->addFile($file_folder); // Adding files into zip  
////        }  
//        $zip->close();
//        //header('Content-type: application/zip');  
//        header('Content-Disposition: attachment; filename="'.$zip_name.'"');  
//        readfile($zip_name); 
////        if(file_exists($zip_name))  
////        {  
////             // push to download the zip  
////             
////             readfile($zip_name);  
////             // remove zip file is exists in temp path  
////             unlink($zip_name);  
////        } 
//             

//      }  
 }  

?>