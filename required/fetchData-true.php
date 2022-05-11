<?php

$user = accountDB::getUserByID($_SESSION['accountID']);
$account = new account($user['accountID'], $user['username'], $user['email'], $user['accountType'], $user['fname'], $user['lname'], $user['bio']);
$posts = postDB::getPostsByAccountID($_SESSION['accountID']);
$postUpdate = true;
