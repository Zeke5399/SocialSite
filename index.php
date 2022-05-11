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
        $posts = postDB::getAllPublicPosts();
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
            require("./required/registerValidate.php");

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
        require("./required/loginValidate.php");

        //Call a login method
        accountDB::loginAccount($username, $password);
        //Gets data and makes class
        $user = accountDB::getUser($username);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname'], $user['bio']);
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
        require("./required/fetchData-false.php");

        include("./view/profile.php");
        break;

    case 'account-details-action':
        require("./required/fetchData-false.php");

        $fname = filter_input(INPUT_POST, 'fname');
        $lname = filter_input(INPUT_POST, 'lname');
        $bio = filter_input(INPUT_POST, 'bio');

        $firstnameError = "";
        $lastnameError = "";
        $bioError = "";

        //Validate inputs
        require("./required/accountdetailsValidate.php");

        accountDB::updateDetails($_SESSION['accountID'], $fname, $lname, $bio);

        $message = "<p id='greenText'>Account updated successfully!</p>
       <p>" . $fname . " " . $lname . "</p>";
        include('./view/result_page.php');
        break;

    case 'account-update-action':
        require("./required/fetchData-false.php");

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $usernameError = "";
        $passwordError = "";

        //Validate inputs
        require("./required/accountupdateValidate.php");

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
        require("./required/fetchData-false.php");

        $title = filter_input(INPUT_POST, 'title');
        $postmessage = filter_input(INPUT_POST, 'postmessage');
        $privacysetting = filter_input(INPUT_POST, 'privacysetting');

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

        $titleError = "";
        $postmessageError = "";
        $privacysettingError = "";

        require("./required/postaddValidate.php");

//  Can't make object because postID and postDate have not been set yet.        
//        $post = new post($postID, $_SESSION['accountID'], $title, $message, $privacysetting, $postDate);
        postDB::addPost($_SESSION['accountID'], $title, $postmessage, $fileDestination, $privacysetting);

        $message = "<p id='greenText'>Post Submitted!</p>";

        $title = "";
        $postmessage = "";
        $fileError = "";

        //Refresh the list.
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        include("./view/profile.php");
        break;

    case 'post-remove-action':
        require("./required/fetchData-false.php");

        $postID = filter_input(INPUT_POST, 'postid');
        $post = postDB::getPostByPostID($postID);

        //Remove image if there was one
        if ($post['imgLocation'] != "") {
            unlink($post['imgLocation']);
        }

        postDB::removePost($postID);

        $message = "<p id='greenText'>Post Removed!</p>";
        //Refresh the list.
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        include("./view/profile.php");
        break;

    case 'post-updateform-action':
        require("./required/fetchData-true.php");

        $postID = filter_input(INPUT_POST, 'postid');
        $selectedPost = postDB::getPostByPostID($postID);

        $title = $selectedPost['title'];
        $postmessage = $selectedPost['message'];

        include("./view/profile.php");
        break;

    case 'post-update-action':
        require("./required/fetchData-true.php");

        $postID = filter_input(INPUT_POST, 'postid');
        $title = filter_input(INPUT_POST, 'title');
        $postmessage = filter_input(INPUT_POST, 'postmessage');
        $privacysetting = filter_input(INPUT_POST, 'privacysetting');

        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf');

        $titleError = "";
        $postmessageError = "";
        $privacysettingError = "";

        require("./required/postupdateValidate.php");

        $postUpdate = date("Y-m-d h:i:s");
        postDB::updatePost($postID, $title, $postmessage, $fileDestination, $privacysetting, $postUpdate);

        $message = "<p id='greenText'>Post Updated!</p>";
        //Refresh the list.
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);

        $title = "";
        $postmessage = "";
        $fileError = "";
        $postUpdate = false;
        include("./view/profile.php");
        break;
}
?>