<?php include_once './view/header.php'; ?>

<main>
    <p>Welcome, <?php echo $account->getUsername(); ?></p>
    <p>Email: <?php echo $account->getEmail(); ?></p>
    <?php if($account->getFname() != "" && $account->getLname() != "") { echo "<p>Name: ". $account->getFname(). " ". $account->getLname(). "</p>"; } ?>
    
    <div id="right">
        <fieldset>
        <h3>Posts</h3>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </fieldset>
    </div>
    
    <div id="left">
    <form action="" method="POST">
        <fieldset>
        <h3>Update Account Details</h3>
        <input type="hidden" name="action" value="account-details-action">
        
        <label for="fname">First Name</label>
        <input id="fname" name="fname" type="text" value="<?php if(isset($fname)) { echo $fname;} elseif($account->getFname() != "") { echo $account->getFname();} ?>">
        <span><?php if(isset($fnameError)) { echo $fnameError;} ?></span>
        <br><br>

        <label for="lname">Last Name</label>
        <input id="lname" name="lname" type="text" value="<?php if(isset($lname)) { echo $lname;} elseif($account->getLname() != "") { echo $account->getLname();} ?>">
        <span><?php if(isset($lnameError)) { echo $lnameError;} ?></span>
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
        <span><?php if(isset($usernameError)) { echo $usernameError;} ?></span>
        <br><br>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" value="<?php if(isset($password)) { echo $password;} ?>">
        <span><?php if(isset($passwordError)) { echo $passwordError;} ?></span>
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