<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Accounts</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<div id="wrapper">
    <header>
        <h1>Social Site
        -
        <?php
            $currentDateTime = date('Y-m-d H:i:s');
            echo $currentDateTime;
        ?>
        </h1>
    </header>
    <nav>
        <a href="index.php">Home</a>&nbsp;-&nbsp;
        <a href="register.php">Register</a>&nbsp;-&nbsp;
        <a href="login.php">Login</a>    
    </nav>