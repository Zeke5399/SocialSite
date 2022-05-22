<?php

$validator = new validation();
if ($postDate != "" && !strtotime($postDate)) {
    $postdateError = "Please correct the format of the date!";
    require ("./required/base-welcomepage-tabs.php");
    include("./view/welcome_page.php");
    exit();
}

if ($validator->emptyInput($beforeAfter) && !$validator->emptyInput($postDate)) {
    $beforeafterError = "When entering a date, please select either before or after!";
    require ("./required/base-welcomepage-tabs.php");
    include("./view/welcome_page.php");
    exit();
}