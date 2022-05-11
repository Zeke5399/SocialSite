<?php

$validator = new validation();
if ($validator->emptyInput($username)) {
    $usernameError = "Username is empty!";
    include("./view/register.php");
    exit();
}
if ($validator->emptyInput($email)) {
    $emailError = "E-mail is empty!";
    include("./view/register.php");
    exit();
}
if ($validator->emptyInput($password)) {
    $passwordError = "Password is empty!";
    include("./view/register.php");
    exit();
}
if ($validator->validName($username)) {
    $usernameError = "Please correct the formatting for your username!";
    include("./view/register.php");
    exit();
}
if ($validator->usernameLength($username)) {
    $usernameError = "Your username must be between 4-15 characters!";
    include("./view/register.php");
    exit();
}
if ($validator->validEmail($email)) {
    $emailError = "E-Mail is invalid!";
    include("./view/register.php");
    exit();
}
if ($validator->passwordLength($password)) {
    $passwordError = "Your password must be between 10-20 characters!";
    include("./view/register.php");
    exit();
}
if ($validator->usernameTaken($username)) {
    $usernameError = "Username taken!";
    include("./view/register.php");
    exit();
}
if ($validator->emailTaken($email)) {
    $emailError = "E-Mail taken!";
    include("./view/register.php");
    exit();
}