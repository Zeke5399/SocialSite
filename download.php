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
        echo "<p id='redText'>File does not exist.</p>" . "<p>". $filename. "</p>";
    }
} else {
    echo "<p id='redText'>Filename is not defined.</p>" . "<p>". $filename. "</p>";
}
?>