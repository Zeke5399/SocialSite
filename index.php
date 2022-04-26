<?php

$lifetime = 60 * 60 * 24 * 14;    // 2 weeks in seconds
session_set_cookie_params($lifetime, '/');
session_start();

    include ('db/dbh.php');
    include ('model/validation.php');
    
    include ('model/account.php');
    
    include ('db/accountDB.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === null) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === null) {
        $action = 'welcome_page';
    }
}

switch ($action) {
//this will be the default display page
    case 'welcome_page':
    include('./view/welcome_page.php');
    break;

    case 'register':
    include('./view/register.php');
    break;

    case 'register-action':
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    
    $usernameError = "";
    $passwordError = "";
    //Validate inputs
    $validator = new validation();
    if($validator->emptyInput($username)) {
        $usernameError = "Username is empty!";
        include("./view/register.php");
        exit();
    }
    if($validator->emptyInput($password)) {
        $passwordError = "Password is empty!";
        include("./view/register.php");
        exit();
    }
    if($validator->validName($username)) {
        $usernameError = "Please correct the formatting for your username!";
        include("./view/register.php");
        exit();
    }
    if($validator->usernameLength($username)) {
        $usernameError = "Your username must be between 4-15 characters!";
        include("./view/register.php");
        exit();
    }
    if($validator->passwordLength($password)) {
        $passwordError = "Your password must be between 10-20 characters!";
        include("./view/register.php");
        exit();
    }
    if($validator->usernameTaken($username)) {
        $usernameError = "Username taken!";
        include("./view/register.php");
        exit();
    }
    
    //Put data into class
    //$signup = new account($username, $password);
    //Call a signup method
    accountDB::signupAccount($username, $password);
    //$signup->signupAccount($username, $password);
    
    //Send to success page if it works
    $message = "<p id='greenText'>You have successfully signed up!</p>";
    include('./view/result_page.php');
    break;

    case 'login':
    include('./view/login.php');
    break;

    case 'login-action':
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    
    $usernameError = "";
    $passwordError = "";
    //Validate inputs
    $validator = new validation();
    if($validator->emptyInput($username)) {
        $usernameError = "Username is empty!";
        include("./view/login.php");
        exit();
    }
    if($validator->emptyInput($password)) {
        $passwordError = "Password is empty!";
        include("./view/login.php");
        exit();
    }

    //Call a login method
    accountDB::loginAccount($username, $password);
    //Gets data and makes class
    $user = accountDB::getUser($username);
    $account = new account($user['accountID'], $user['username'], $user['accountType'], $user['fname'], $user['lname']);
    //Send to success page if it works
    $message = "<p id='greenText'>You have successfully logged in!</p>
       <p>Welcome, ". $account->getUsername(). "<br>".
//        "Account Type: ". $_SESSION['accountType'].
        "</p>";
    include("./view/result_page.php");
    
    break;

    case 'logout':
    session_start();
    session_unset();
    session_destroy();
    header("Location: ./index.php");
    break;

}
?>