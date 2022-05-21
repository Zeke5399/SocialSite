<?php

if (isset($_GET['path'])) {
//Read the filename
    $filename = $_GET['path'];
//Check the file exists or not
    if (file_exists($filename)) {

//Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));

//Clear system output buffer
        flush();

//Read the size of the file
        readfile($filename);

//Terminate from the script
        die();
    } else {
        $message = "<p id='redText'>File does not exist.</p>" . "<p>" . $filename . "</p>";
        include("./view/result_page.php");
        exit();
    }
} else {
    $message = "<p id='redText'>Filename is not defined.</p>" . "<p>" . $filename . "</p>";
    include("./view/result_page.php");
    exit();
}
?>