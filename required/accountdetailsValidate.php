<?php

$validator = new validation();
if ($validator->emptyInput($fname)) {
    $fnameError = "First name is empty!";
    include("./view/profile.php");
    exit();
}
if ($validator->emptyInput($lname)) {
    $lnameError = "Last name is empty!";
    include("./view/profile.php");
    exit();
}
if ($validator->nameLength($fname)) {
    $fnameError = "First name can not be longer than 25 characters!";
    include("./view/profile.php");
    exit();
}
if ($validator->nameLength($lname)) {
    $lnameError = "Last name can not be longer than 25 characters!";
    include("./view/profile.php");
    exit();
}
if ($validator->validNameNoNum($fname)) {
    $fnameError = "Please correct the formatting for your first name!";
    include("./view/profile.php");
    exit();
}
if ($validator->validNameNoNum($lname)) {
    $lnameError = "Please correct the formatting for your last name!";
    include("./view/profile.php");
    exit();
}
if ($validator->bioLength($bio)) {
    $bioError = "Length cannot be longer than 100 characters!";
    include("./view/profile.php");
    exit();
}