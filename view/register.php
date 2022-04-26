<?php include_once './view/header.php'; ?>

<main>
    <p>Register</p>
    
    <form action="index.php" method="POST">
        <fieldset>
        <input type="hidden" name="action" value="register-action">
            
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php if(isset($username)) { echo $username;} ?>">
        <span id='redText'><?php if(isset($usernameError)) { echo $usernameError;} ?></span>
        <br><br>

        <label for="password">Password</label>
        <input id="password" name="password" type="text" value="<?php if(isset($password)) { echo $password;} ?>">
        <span id='redText'><?php if(isset($passwordError)) { echo $passwordError;} ?></span>
        <br><br>

        <button id="submitButton" name="registerSubmit" type="submit">Register</button><br>
        </fieldset>
    </form>
    
</main>

<?php include_once './view/footer.php'; ?>