<?php
    include_once 'templates/header.php';
?>

<main>

    <p>Login - Not Working Yet</p>
    <form action="../includes/login.inc.php" method="POST">
        <label for="email">E-Mail</label>
        <input id="email" name="email" type="text" value="<?php echo htmlspecialchars($Email); ?>">
        <span><?php if(isset($emailError)) { echo $emailError; } ?></span>
        <br>

        <label for="password">Password</label>
        <input id="password" name="email" type="paassword" value="<?php echo htmlspecialchars($Password); ?>">
        <span><?php if(isset($passwordError)) { echo $passwordError; } ?></span>
        <br>

        <button id="submitButton" name="loginSubmit" type="submit">Login</button>
    </form>
    <br>

</main>

<?php
    include_once 'templates/footer.php';
?>