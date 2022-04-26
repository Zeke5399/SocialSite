<?php
    include_once 'templates/header.php';
?>

<main>
    <p>Register</p>
    <form action="includes/signup.inc.php" method="POST">
        <label for="name">Name</label>
        <input id="name" name="name" type="text" value="<?php echo htmlspecialchars($Name); ?>">
        <span><?php if(isset($nameError)) { echo $nameError; } ?></span>
        <br>

        <label for="city">City</label>
        <input id="city" name="city" type="text" value="<?php echo htmlspecialchars($City); ?>">
        <span><?php if(isset($cityError)) { echo $cityError; } ?></span>
        <br>

        <label for="state">State</label>
        <input id="state" name="state" type="text" value="<?php echo htmlspecialchars($State); ?>">
        <span><?php if(isset($stateError)) { echo $stateError; } ?></span>
        <br>

        <label for="email">E-Mail</label>
        <input id="email" name="email" type="text" value="<?php echo htmlspecialchars($Email); ?>">
        <span><?php if(isset($emailError)) { echo $emailError; } ?></span>
        <br>

        <label for="password">Password</label>
        <input id="password" name="password" type="text" value="<?php echo htmlspecialchars($Password); ?>">
        <span><?php if(isset($passwordError)) { echo $passwordError; } ?></span>
        <br>

        <button id="submitButton" name="signupSubmit" type="submit">Register</button>
    </form>

    <p>Output</p>
    <span>
        <?php

        if(isset($data))
        {
            echo "<table border='1'>
            <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>State</th>
            <th>Email</th>
            </tr>";

            while($row = mysqli_fetch_array($data))
            {
            echo "<tr>";
            echo "<td>" . $row['userID'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['City'] . "</td>";
            echo "<td>" . $row['State'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "</tr>";
            }
            echo "</table>";

            // mysqli_close($con);
        }

        ?>    
    </span>
    <form action="../includes/load.inc.php" method="POST">
        <button id="submitButton" type="submit">Load Users</button>
    </form>
    <br>
</main>

<?php
    include_once 'templates/footer.php';
?>