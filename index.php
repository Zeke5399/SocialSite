<?php

$lifetime = 60 * 60 * 24 * 14;    // 2 weeks in seconds
session_set_cookie_params($lifetime, '/');
session_start();

include ('db/dbh.php');
include ('model/validation.php');
include ('mail/mailer.php');

include ('model/account.php');
include ('model/post.php');

include ('db/accountDB.php');
include ('db/postDB.php');

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
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        $usernameError = "";
        $emailError = "";
        $passwordError = "";

        $stage = filter_input(INPUT_POST, 'stage');
        if (!isset($stage)) {
            $stage = 0;
        }

        if ($stage == 0) {
            //Validate inputs
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

            //Generate Vkey
            $vkey = md5(time() . $username);

            //Send email to verify account
            mailer::sendMail($email, $vkey);

            //Send to success page if it works
//    $message = "<p id='greenText'>You have successfully signed up!</p>";
            $message = "<p id='greenText'>Enter Validation Key: " . $vkey . "</p>";
            $message .= "<form action='' method='POST'> "
                    . "<input type='hidden' name='action' value='register-action'> "
                    . "<input type='hidden' name='stage' value='1'> "
                    . "<input type='hidden' name='username' value=" . $username . ">"
                    . "<input type='hidden' name='email' value=" . $email . ">"
                    . "<input type='hidden' name='password' value=" . $password . ">"
                    . "<input type='hidden' name='correctvkey' value=" . $vkey . ">"
                    . "<input type='text' name='vkey'>"
                    . "<button id='vkeyButton' name='vkeySubmit' type='submit'>Verify</button>" . "<form><br><br>";
            include('./view/register.php');
        }

        if ($stage == 1) {

            $vkey = filter_input(INPUT_POST, 'vkey');
            $correctvkey = filter_input(INPUT_POST, 'correctvkey');

            if ($vkey == $correctvkey) {
                accountDB::signupAccount($username, $email, $password);
                $message = "<p id='greenText'>Correct key</p><p>Your account has been set up.</p>";
            } else {
                $message = "<p id='redText'>Wrong key.</p><p>Please try again.</p>";
            }
            include('./view/result_page.php');
        }

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

        //Call a login method
        accountDB::loginAccount($username, $password);
        //Gets data and makes class
        $user = accountDB::getUser($username);
        $account = new account($user['accountID'], $user['username'], $user['accountType'], $user['email'], $user['fname'], $user['lname']);
        //Send to success page if it works
        $message = "<p id='greenText'>You have successfully logged in!</p>
       <p>Welcome, " . $account->getUsername() . "<br>" .
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

    case 'profile':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);

        include("./view/profile.php");
        break;

    case 'account-details-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);

        $fname = filter_input(INPUT_POST, 'fname');
        $lname = filter_input(INPUT_POST, 'lname');

        $firstnameError = "";
        $lastnameError = "";
        //Validate inputs
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
        if ($validator->validName($fname)) {
            $fnameError = "Please correct the formatting for your first name!";
            include("./view/profile.php");
            exit();
        }
        if ($validator->validName($lname)) {
            $lnameError = "Please correct the formatting for your last name!";
            include("./view/profile.php");
            exit();
        }

        accountDB::updateDetails($_SESSION['accountID'], $fname, $lname);

        $message = "<p id='greenText'>Account updated successfully!</p>
       <p>" . $fname . " " . $lname . "</p>";
        include('./view/result_page.php');
        break;

    case 'account-update-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $usernameError = "";
        $passwordError = "";
        //Validate inputs
        $validator = new validation();
        if ($validator->emptyInput($username)) {
            $usernameError = "Username is empty!";
            include("./view/profile.php");
            exit();
        }
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
        if ($validator->usernameLength($username)) {
            $usernameError = "Your username must be between 4-15 characters!";
            include("./view/profile.php");
            exit();
        }
        if ($validator->passwordLength($password)) {
            $passwordError = "Your password must be between 10-20 characters!";
            include("./view/profile.php");
            exit();
        }
        if ($validator->usernameTaken($username)) {
            $usernameError = "Username taken!";
            include("./view/profile.php");
            exit();
        }

        accountDB::updateUser($_SESSION['accountID'], $username, $password);

        $message = "<p id='greenText'>Account updated successfully!</p>
       <p>" . $username . "</p>";
        include('./view/result_page.php');
        break;

    case 'account-delete-action':
        accountDB::removeUser($_SESSION['accountID']);
        session_unset();
        session_destroy();
        $message = "<p id='greenText'>Account deleted successfully!</p>";
        include('./view/result_page.php');
        break;

    case 'post-add-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);

        $title = filter_input(INPUT_POST, 'title');
        $postmessage = filter_input(INPUT_POST, 'postmessage');
        $privacysetting = filter_input(INPUT_POST, 'privacysetting');

        $titleError = "";
        $postmessageError = "";
        $privacysettingError = "";

        $validator = new validation();
        if ($validator->emptyInput($title)) {
            $titleError = "Please enter a title!";
            include("./view/profile.php");
            exit();
        }
        if ($validator->emptyInput($privacysetting)) {
            $privacysettingError = "Please select either public or private!";
            include("./view/profile.php");
            exit();
        }

//  Can't make object because postID and postDate have not been set yet.        
//        $post = new post($postID, $_SESSION['accountID'], $title, $message, $privacysetting, $postDate);
        postDB::addPost($_SESSION['accountID'], $title, $postmessage, $privacysetting);

        $message = "<p id='greenText'>Post Submitted!</p>";
        include("./view/profile.php");
        break;
}
?>