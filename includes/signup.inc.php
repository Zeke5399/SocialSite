<?php
// if (isset($_POST['signupSubmit']))

    include_once 'db.inc.php';

    // $Name = $_POST['name'];
    // $City = $_POST['city'];
    // $State = $_POST['state'];
    // $Email = $_POST['email'];

    $Name = filter_input(INPUT_POST, 'name');
    $City = filter_input(INPUT_POST, 'city');
    $State = filter_input(INPUT_POST, 'state');
    $Email = filter_input(INPUT_POST, 'email');
    $Password = filter_input(INPUT_POST, 'password');

    if(empty($Name))
    {
    	$nameError = 'Name must not be blank!';
    }
    elseif(!preg_match("/^[a-zA-Z-' ]*$/", $Name))
    {
    	$nameError = 'Only Letters and White Space Allowed!';
    }
    elseif(strlen($Name) < 2)
    {
    	$nameError = 'Name needs to be 2 characters or longer!';
    }
    elseif(strlen($Name) > 40)
    {
        $nameError = 'Name needs to be less than 40 characters!';
    }

    if(empty($City))
    {
    	$cityError = 'City must not be blank!';
    }
    elseif(strlen($City) < 3)
    {
    	$cityError = 'City needs to be 3 characters or longer!';
    }
    elseif(strlen($City) > 40)
    {
        $cityError = 'City needs to be less than 40 characters!';
    }

    if(empty($State))
    {
    	$stateError = 'State must not be blank!';
    }
    elseif ($State != "NE" &&
            $State != "IA" &&
            $State != "MN" &&
            $State != "WI" &&
            $State != "MI" &&
            $State != "IL" &&
            $State != "IN" &&
            $State != "OH" &&
            $State != "PA" &&
            $State != "MD" &&
            $State != "NJ")
    {
    	$stateError = 'State must be one of the following: NE, IA, MN, WI, MI, IL, IN, OH, PA, MD, NJ';
    }


    $emailTaken = mysqli_query($conn, "SELECT * FROM users WHERE Email = '$Email'");
    if(empty($Email))
    {
    	$emailError = 'Email must not be blank!';
    }
    elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL))
    {
    	$emailError = 'Email must not be formatted correctly!';
    }
    elseif(strlen($Email) > 40)
    {
        $emailError = 'Email needs to be less than 40 characters!';
    }
    elseif(mysqli_num_rows($emailTaken))
    {
        $emailError = 'Email has been taken!';
    }

    if(empty($Password))
    {
        $passwordError = 'Password must not be blank!';
    }
    elseif(strlen($Password) < 10)
    {
        $passwordError = 'Password needs to be 10 characters or longer!';
    }
    elseif(strlen($Password) > 80)
    {
        $passwordError = 'Password needs to be less than 80 characters!';
    }


    if($nameError == '' && $cityError == '' && $stateError == '' && $emailError == '' && $passwordError== '')
    {
		$insert = "INSERT INTO users (Name, City, State, Email, Password) VALUES ('$Name', '$City', '$State', '$Email', '$Password')";
		mysqli_query($conn, $insert);

		include('../includes/success.php');
	}
    else
    {
        include('../register.php');
    }
    
    mysqli_close($conn);
?>