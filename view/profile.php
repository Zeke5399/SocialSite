<?php include_once './view/header.php'; ?>

<main id="customHeight">
    <?php if(isset($message)) { echo $message; }?>
    
    <p>
    Welcome, <?php echo $account->getUsername(); ?><br>
    Email: <?php echo $account->getEmail(); ?><br>
    <?php if($account->getFname() != "" && $account->getLname() != "") { echo "Name: ". $account->getFname(). " ". $account->getLname(); } ?>
    </p>
    
    <div id="right">
    <form action="" method="POST">
        <fieldset id="leftAlign">
        <h3>Add Post</h3>
        <input type="hidden" name="action" value="post-add-action">
        
        <label for="title">Title</label>
        <input id="title" name="title" type="text" value="<?php if(isset($title)) { echo $title;} ?>">
        <span id='redText'><?php if(isset($titleError)) { echo $titleError;} ?></span>
        <br><br>

        <label for="postmessage">Message</label>
        <input id="postmessage" name="postmessage" type="text" value="<?php if(isset($postmessage)) { echo $postmessage;} ?>">
        <span id='redText'><?php if(isset($postmessageError)) { echo $postmessageError;} ?></span>
        <br><br>
        
        <input type="radio" id="public" name="privacysetting" value="public" checked="true">
        <label for="admin">Public</label>
        <input type="radio" id="private" name="privacysetting" value="private">
        <label for="employee">Private</label>
        <span id='redText'><?php if(isset($privacysettingError)) { echo "<br>", $privacysettingError;} ?></span>
        <br><br>
        
        <button id="submitButton" name="postSubmit" type="submit">Add Post</button>
        </fieldset>
        <br>
    
    </form>
        
        <fieldset>
        <h3>Your Posts</h3>
            <ul>
            <?php
            if(isset($posts)) {
                if(!postDB::checkPostsByAccountID($_SESSION['accountID']))
                {
                    echo "<li>";
                    echo "<Strong>No Posts Found.</Strong>";
                    echo "</li>";
                } else {
            foreach ($posts as $post) {
                echo "<li>";
                echo "<Strong>Title:</Strong> ", $post['title'], "<br>";
                echo "<Strong>Message:</Strong> ", $post['message'], "<br>";
                echo "<Strong>Date:</Strong> ", $post['postDate'], "<br>";
                echo "<Strong>Privacy:</Strong> ", $post['privacySetting'];
                include './view/remove_post_button.php';
                echo "</li>";
            }
            }
            }
            ?>
            </ul>
        </fieldset>
    </div>
    
    <div id="left">
    <form action="" method="POST">
        <fieldset>
        <h3>Update Account Details</h3>
        <input type="hidden" name="action" value="account-details-action">
        
        <label for="fname">First Name</label>
        <input id="fname" name="fname" type="text" value="<?php if(isset($fname)) { echo $fname;} elseif($account->getFname() != "") { echo $account->getFname();} ?>">
        <span id='redText'><?php if(isset($fnameError)) { echo $fnameError;} ?></span>
        <br><br>

        <label for="lname">Last Name</label>
        <input id="lname" name="lname" type="text" value="<?php if(isset($lname)) { echo $lname;} elseif($account->getLname() != "") { echo $account->getLname();} ?>">
        <span id='redText'><?php if(isset($lnameError)) { echo $lnameError;} ?></span>
        <br><br>
        
        <button id="submitButton" name="detailSubmit" type="submit">Submit</button>
        </fieldset>
        <br>
    
    </form>

<form action="" method="POST">
        <fieldset>
        <h3>Update Account</h3>
        <input type="hidden" name="action" value="account-update-action">
        
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php if(isset($username)) { echo $username;} else { echo $account->getUsername();} ?>">
        <span id='redText'><?php if(isset($usernameError)) { echo $usernameError;} ?></span>
        <br><br>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" value="<?php if(isset($password)) { echo $password;} ?>">
        <span id='redText'><?php if(isset($passwordError)) { echo $passwordError;} ?></span>
        <br><br>
        
        <button id="submitButton" name="detailSubmit" type="submit">Submit</button>
        </fieldset>
        <br>
    
</form>

<form action="" method="POST">
        <fieldset>
        <h3>Delete Account</h3>
        <input type="hidden" name="action" value="account-delete-action">
        
        <button id="submitButton" name="deleteSubmit" type="submit">Submit</button>
        </fieldset>
        <br>
    
</form>
    </div>
</main>

<?php include './view/footer.php'; ?>