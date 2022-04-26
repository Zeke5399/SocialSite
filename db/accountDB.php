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
            
            //Sets the account type as a session var
            $_SESSION["accountType"] = $user["accountType"];   
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

//    public static function updateUser($accountID, $username, $password) {
//        $db = dbh::getDB();
//        $query = ('UPDATE account SET username = :username, password = :password WHERE accountID = :accountid');
//        $statement = $db->prepare($query);
//        $hashedPwd = sha1($password);
//        $statement->bindValue(':username', $username);
//        $statement->bindValue(':password', $hashedPwd);
//        $statement->bindValue(':accountid', $accountID);
//        try {
//            $statement->execute();
//        } catch (Exception $e) {
//            include('./errors/dbError.php');
//            exit();
//        }
//        $statement->closeCursor();
//    }    
    
//    public static function removeUser($accountID) {
//        $db = dbh::getDB();
//        $query = ('DELETE FROM account WHERE accountID = :accountid');
//        $statement = $db->prepare($query);
//        $statement->bindValue(':accountid', $accountID);
//        try {
//            $statement->execute();
//        } catch (Exception $e) {
//            include('./errors/dbError.php');
//            exit();
//        }
//        $statement->closeCursor();
//    }
    
}
