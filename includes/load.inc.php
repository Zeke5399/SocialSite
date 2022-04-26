<?php
    include_once 'db.inc.php';




	$sql = "SELECT * FROM users";
	$data = mysqli_query($conn, $sql);

    include('../register.php');
    mysqli_close($conn);
?>