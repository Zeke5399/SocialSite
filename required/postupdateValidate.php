<?php

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

            $post = postDB::getPostByPostID($postID);

            //Remove image if there was one
            if ($post['imgLocation'] != "") {
                unlink($post['imgLocation']);
            }
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