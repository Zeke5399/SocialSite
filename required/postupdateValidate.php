<?php

use Google\Cloud\Storage\StorageClient;

$validator = new validation();
if ($validator->emptyInput($title)) {
    $titleError = "Please enter a title!";
    $fileError = "";
    include("./view/profile.php");
    exit();
}
if ($validator->titleLength($title)) {
    $titleError = "Title cannot be longer than 30 characters!";
    $fileError = "";
    include("./view/profile.php");
    exit();
}
if ($validator->messageLength($postmessage)) {
    $postmessageError = "Message cannot be longer than 30 characters!";
    $fileError = "";
    include("./view/profile.php");
    exit();
}
if ($validator->emptyInput($privacysetting)) {
    $privacysettingError = "Please select either public or private!";
    $fileError = "";
    include("./view/profile.php");
    exit();
}

//File Validation
if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
        if ($fileSize < 1000000) {
            $fileNameNew = uniqid('', true) . "." . $fileActualExt;
            $fileDestination = "uploads/" . $fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);

            //Uploading to cloud
            try {
                $storage = new StorageClient([
                    'keyFilePath' => getcwd() . '/zi5399-7439e7b3c462.json',
                ]);

                $bucketName = 'zi5399web-bucket';
                $cloudFile = $fileDestination;
                $bucket = $storage->bucket($bucketName);
                $object = $bucket->upload(
                        fopen($cloudFile, 'r'),
                        [
                            'predefinedAcl' => 'publicRead'
                        ]
                );
            } catch (Exception $e) {
                $message = $e->getMessage();
                include("./view/result_page.php");
                exit();
            }

            unlink($fileDestination);
            $fileDestination = "https://storage.googleapis.com/" . $bucketName . "/" . $fileNameNew;
        } else {
            $fileError = "File was too big!";
            include("./view/profile.php");
            exit();
        }
    } else {
        $fileError = "There was an error uploading the file!";
        include("./view/profile.php");
        exit();
    }
} elseif ($fileActualExt == "") {
    $fileDestination = null;
} else {
    $fileError = "You can't upload files of this type!";
    include("./view/profile.php");
    exit();
}

//Checks to see if you originally made the post.
if (!$validator->validPostID($postID, $_SESSION['accountID'])) {
    $message = "<p id='redText'>Error the post id is not associated with this account!</p>"
            . "<p>Please reload your page.</p>";
    include("./view/profile.php");
    exit();
}