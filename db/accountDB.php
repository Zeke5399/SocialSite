<?php
/**
 *
 *
 * @author zekei
 */
class accountDB {
    public static function loginAccount($username, $password)
    {
        //Looks for username in db
        $userCheck = self::checkUsername($username);
        if($userCheck == false) {
            $usernameError = "Username not found!";
            include("./view/login.php");
            exit();
        }

        //Sees if password matches username
        $checkPwd = self::checkPassword($username, $password);
        if($checkPwd == false)
        {
            $passwordError = "Wrong password!";
            include("./view/login.php");
            exit();
        }
        elseif($checkPwd == true)
        {
            //Gets the full row of the desired user
            $user = self::getUser($username);
            
            //Sets the session under that user
            $_SESSION["accountID"] = $user["accountID"];
            
            //Gets account type if it can find one
            //else sets it to null
            $accountType = self::getAccountType($user["accountID"]);
            
            //Sets the account type as a session var
            $_SESSION["accountType"] = $accountType;   
        }
    }
    
    public static function signupAccount($username, $password)
    {
        //This function should get called after validation takes place 
        //in the signup.php controller.
        
        //connection to database
        $db = dbh::getDB();
        //prepared query
        $query = ('INSERT INTO account (username, password) VALUES (:username, :password)');
        //prepated statement
        $statement = $db->prepare($query);
        //hash password
        $hashedPwd = sha1($password);
        //bind values
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $hashedPwd);
        //test execute
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        //clear out the prepared statement
        $statement->closeCursor();
    }
    
    public static function checkUsername($username) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM account WHERE username = :username');
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $resultCheck;
        if($statement->rowCount() > 0) {
            $resultCheck = true;
	}
	else {
            $resultCheck = false;
	}
        $statement->closeCursor();
	return $resultCheck;
    }
    
    public static function checkPassword($username, $password) {
        $db = dbh::getDB();
        $query = ('SELECT password FROM account WHERE username = :username');
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        
        $row = $statement->fetch();
        $pwdHashed = $row['password'];

        //Compares hashes
        $checkPwd = false;
        if(sha1($password) == $pwdHashed) {
            $checkPwd = true;
        }
        $statement->closeCursor();
        return $checkPwd;
    }
    
    public static function getUser($username) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM account WHERE username = :username');
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetch();
        $statement->closeCursor();
        return $row;
    }
    
    public static function getUserByID($accountID) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM account WHERE accountID = :accountid');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetch();
        $statement->closeCursor();
        return $row;
    }
    
    public static function getAccountType($accountID) {
        $accountType = "null";
        
        $isAdmin = self::checkAccountType("admin", $accountID);
        $isEmployee = self::checkAccountType("employee", $accountID);
        $isCustomer = self::checkAccountType("customer", $accountID);
        
        //if nothing was found, account type remains null
        if($isAdmin == true) {
            $accountType = "admin";
        }
        elseif ($isEmployee == true) {
            $accountType = "employee";
        }
        elseif ($isCustomer == true) {
            $accountType = "customer";
        }
        else {
            $accountType = "null";
        }
        
	return $accountType;
    }
    
    public static function checkAccountType($tableName, $accountID) {
        $db = dbh::getDB();
        
        //Needs to check for 3 possible account types admin, employee, customer
        //Bind Value does not work for table name, so I had to do it as shown below.
        $query = ('SELECT * FROM '. $tableName .' WHERE accountID = :accountID');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountID', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $resultCheck;
        if($statement->rowCount() > 0) {
            $resultCheck = true;
	}
	else {
            $resultCheck = false;
	}
        $statement->closeCursor();
        
        return $resultCheck;
    }

    public static function updateUser($accountID, $username, $password) {
        $db = dbh::getDB();
        $query = ('UPDATE account SET username = :username, password = :password WHERE accountID = :accountid');
        $statement = $db->prepare($query);
        $hashedPwd = sha1($password);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $hashedPwd);
        $statement->bindValue(':accountid', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
    }
    
    public static function updateAccount($accountID, $accountType, $firstName, $lastName) {
        $tableName = $accountType;
        $db = dbh::getDB();
        $query = ('INSERT INTO '. $tableName .' (accountID, firstName, lastName) VALUES (:accountid, :firstname, :lastname)');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        $statement->bindValue(':firstname', $firstName);
        $statement->bindValue(':lastname', $lastName);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
        
        $_SESSION["accountType"] = $accountType;
    }
    
    public static function updateEmployee($accountID, $accountType, $firstName, $lastName, $department) {
        $tableName = $accountType;
        $db = dbh::getDB();
        $query = ('INSERT INTO '. $tableName .' (accountID, firstName, lastName, department) VALUES (:accountid, :firstname, :lastname, :department)');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        $statement->bindValue(':firstname', $firstName);
        $statement->bindValue(':lastname', $lastName);
        $statement->bindValue(':department', $department);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
        
        $_SESSION["accountType"] = $accountType;
    }
    
    public static function removeUser($accountID) {
        $db = dbh::getDB();
        $query = ('DELETE FROM account WHERE accountID = :accountid');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
    }
    
    public static function removeAccount($accountID, $accountType) {
        $tableName = $accountType;
        $db = dbh::getDB();
        $query = ('DELETE FROM '. $tableName .' WHERE accountID = :accountid');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
    }

    public static function getAccountDetails($accountType, $accountID) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM '. $accountType .' WHERE accountID = :accountid');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetch();
        $statement->closeCursor();
        return $row;
    }
}
