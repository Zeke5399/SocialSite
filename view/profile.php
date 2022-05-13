<?php include_once './view/header.php'; ?>

<main id="customHeight">
    <?php if(isset($message)) { echo $message; }?>
    
    <p>
    Welcome, <?php echo $account->getUsername(); ?><br>
    Email: <?php echo $account->getEmail(); ?><br>
    <?php if($account->getFname() != "" && $account->getLname() != "") { echo "Name: ". $account->getFname(). " ". $account->getLname(). "<br>"; } ?>
    <?php if($account->getBio() != "") { echo "Bio:<br> <textarea rows='4' cols='50' readonly>". $account->getBio(). "</textarea><br>"; } ?>
    </p>
    
    <div id="right">
    <?php if($postUpdate == true) { include './view/post_update_form.php'; } else { include './view/post_add_form.php'; } ?>
        
        <fieldset>
        <h3>Your Posts</h3>
            <ul id="postBox">
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
                if ($post['postUpdate'] != null) { echo "(edited)<br>"; }
                echo "<Strong>Title:</Strong> ", $post['title'], "<br>";
                if($post['message'] != "") { echo "<Strong>Message:</Strong> ", $post['message'], "<br>"; }
                echo "<Strong>Date:</Strong> ", date("m-d-Y H:i:s", strtotime($post['postDate'])), "<br>";
                echo "<Strong>Privacy:</Strong> ", $post['privacySetting'];
                if($post['imgLocation'] != "") { echo "<img class='' src='". $post['imgLocation'] ."' alt='post image.'>"; }
                include './view/update_post_button.php';
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
        
        <span id="redText">*</span><label for="fname">First Name</label>
        <input id="fname" name="fname" type="text" value="<?php if(isset($fname)) { echo $fname;} elseif($account->getFname() != "") { echo $account->getFname();} ?>">
        <span id='redText'><?php if(isset($fnameError)) { echo $fnameError;} ?></span>
        <br><br>

        <span id="redText">*</span><label for="lname">Last Name</label>
        <input id="lname" name="lname" type="text" value="<?php if(isset($lname)) { echo $lname;} elseif($account->getLname() != "") { echo $account->getLname();} ?>">
        <span id='redText'><?php if(isset($lnameError)) { echo $lnameError;} ?></span>
        <br><br>
        
        <label for="bio">Bio</label>
        <textarea id="bio" name="bio" rows="4" cols="50"><?php if(isset($bio)) { echo $bio;} elseif($account->getBio() != "") { echo $account->getBio();} ?></textarea>
        <span id='redText'><?php if(isset($bioError)) { echo $bioError;} ?></span>
        <br><br>
        
        <button id="submitButton" name="detailSubmit" type="submit">Submit</button>
        </fieldset>
        <br>
    
    </form>

<form action="" method="POST">
        <fieldset>
        <h3>Update Account</h3>
        <input type="hidden" name="action" value="account-update-action">
        
        <span id="redText">*</span><label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php if(isset($username)) { echo $username;} else { echo $account->getUsername();} ?>">
        <span id='redText'><?php if(isset($usernameError)) { echo $usernameError;} ?></span>
        <br><br>

        <span id="redText">*</span><label for="password">Password</label>
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