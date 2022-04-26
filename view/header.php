<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Social Site</title>
    <link rel="stylesheet" href="./style.css" />
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
        <a href="./index.php?action=welcome_page">Home</a>&nbsp;-&nbsp;
        <a href="./index.php?action=register">Register</a>&nbsp;-&nbsp;
        <?php
            if (isset($_SESSION['accountID']))
            {
                echo '<a href="./index.php?action=logout">Logout</a> &nbsp; &nbsp;';
            }
            else
            {
                echo '<a href="./index.php?action=login">Login</a> &nbsp; &nbsp;';
            }
        ?>
    </nav>