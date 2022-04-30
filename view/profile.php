<?php include_once './view/header.php'; ?>

<main>
    <p>Welcome, <?php echo $account->getUsername(); ?></p>
    <p>Email: <?php echo $account->getEmail(); ?></p>
    
    <div id="left">
    <form action="" method="POST">
        <fieldset>
        <h3>Update Account Details</h3>
        <input type="hidden" name="action" value="account-details-action">
        
        <label for="firstname">First Name</label>
        <input id="firstname" name="firstname" type="text" value="<?php if(isset($firstName)) { echo $firstName;} elseif($_SESSION['accountType'] != "null") { echo $account->getFirstName();} ?>">
        <span><?php if(isset($firstnameError)) { echo $firstnameError;} ?></span>
        <br><br>

        <label for="lastname">Last Name</label>
        <input id="lastname" name="lastname" type="text" value="<?php if(isset($lastName)) { echo $lastName;} elseif($_SESSION['accountType'] != "null") { echo $account->getLastName();} ?>">
        <span><?php if(isset($lastnameError)) { echo $lastnameError;} ?></span>
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
        <input id="password" name="password" type="text" value="<?php if(isset($password)) { echo $password;} ?>">
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