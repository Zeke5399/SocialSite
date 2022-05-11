<?php

$validator = new validation();
if ($validator->emptyInput($username)) {
    $usernameError = "Username is empty!";
    include("./view/login.php");
    exit();
}
if ($validator->emptyInput($password)) {
    $passwordError = "Password is empty!";
    include("./view/login.php");
    exit();
}