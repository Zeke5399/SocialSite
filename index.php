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
        $postUpdate = false;

        include("./view/profile.php");
        break;

    case 'account-details-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        $postUpdate = false;

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
        $postUpdate = false;

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
        $postUpdate = false;

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

        //File Validation
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0 ) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = "uploads/".$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
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
        
        $fileError = "";
        
//  Can't make object because postID and postDate have not been set yet.        
//        $post = new post($postID, $_SESSION['accountID'], $title, $message, $privacysetting, $postDate);
        postDB::addPost($_SESSION['accountID'], $title, $postmessage, $fileDestination, $privacysetting);

        $message = "<p id='greenText'>Post Submitted!</p>";
        //Refresh the list.
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        include("./view/profile.php");
        break;

    case 'post-remove-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        $postUpdate = false;

        $postID = filter_input(INPUT_POST, 'postid');
        $post = postDB::getPostByPostID($postID);

        //Remove image if there was one
        if($post['imgLocation'] != "") {
            unlink($post['imgLocation']);
        }
        
        postDB::removePost($postID);

        $message = "<p id='greenText'>Post Removed!</p>";
        //Refresh the list.
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        include("./view/profile.php");
        break;

    case 'post-updateform-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        $postUpdate = true;

        $postID = filter_input(INPUT_POST, 'postid');
        $selectedPost = postDB::getPostByPostID($postID);
        
        $title = $selectedPost['title'];
        $postmessage = $selectedPost['message'];
        
        include("./view/profile.php");
        break;
    
    case 'post-update-action':
        $user = accountDB::getUserByID($_SESSION['accountID']);
        $account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname']);
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        $postUpdate = true;
        
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

        //File Validation
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0 ) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = "uploads/".$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    
                    $post = postDB::getPostByPostID($postID);

                    //Remove image if there was one
                    if($post['imgLocation'] != "") {
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
        
        $postUpdate = date("Y-m-d h:i:s");
        postDB::updatePost($postID, $title, $postmessage, $fileDestination, $privacysetting, $postUpdate);

        $message = "<p id='greenText'>Post Updated!</p>";
        //Refresh the list.
        $posts = postDB::getPostsByAccountID($_SESSION['accountID']);
        
        $title = "";
        $postmessage = "";
        $postUpdate = false;
        include("./view/profile.php");
        break;
}
?>