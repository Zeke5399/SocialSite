<?php include_once './view/header.php'; ?>

<main>
    <p>Login</p>
    
    <form action="" method="POST">
        <fieldset>
        <input type="hidden" name="action" value="login-action">
            
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php if(isset($username)) { echo $username;} ?>">
        <span id='redText'><?php if(isset($usernameError)) { echo $usernameError;} ?></span>
        <br><br>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" value="<?php if(isset($password)) { echo $password;} ?>">
        <span id='redText'><?php if(isset($passwordError)) { echo $passwordError;} ?></span>
        <br><br>

        <button id="submitButton" name="loginSubmit" type="submit">Login</button>
        </fieldset>
    </form>
    
</main>

<?php include_once './view/footer.php'; ?>