<?php

$validator = new validation();
if ($validator->emptyInput($password)) {
    $passwordError = "Password is empty!";
    include("./view/profile.php");
    exit();
}
if ($validator->validName($username)) {
    $usernameError = "Please correct the formatting for your username!";
    include("./view/profile.php");
    exit();
}
if ($validator->usernameLength($username) && $username != "") {
    $usernameError = "Your username must be between 4-15 characters!";
    include("./view/profile.php");
    exit();
}
if ($validator->passwordLength($password)) {
    $passwordError = "Your password must be between 10-20 characters!";
    include("./view/profile.php");
    exit();
}
//Checks to make sure you are not just changing the case of your current username and then sees if another account
//contains that same username
if (strtolower($account->getUsername()) != strtolower($username) && $validator->usernameTaken($username)) {
    $usernameError = "Username taken!";
    include("./view/profile.php");
    exit();
}