<?php
class validation {
    public static function emptyInput($value)
    {
        $result;
        if(empty($value)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    public static function isInt($value)
    {
        $result;
        if(is_numeric($value)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }
    
    public static function validName($value) {
        $result;
        if(!preg_match("/^[a-zA-Z0-9-' ]*$/", $value)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    public static function usernameTaken($value) {
	$result;
	if(accountDB::checkUsername($value)) {
            $result = true;
	}
	else {
            $result = false;
	}
	return $result;
    }
    
    public static function emailTaken($value) {
	$result;
	if(accountDB::checkEmail($value)) {
            $result = true;
	}
	else {
            $result = false;
	}
	return $result;
    }
    
    public static function usernameLength($value) {
        $result;
	if(strlen($value) > 15) {
            $result = true;
	}
	elseif(strlen($value) < 4) {
            $result = true;
	}
	else {
            $result = false;
	}
	return $result;
    }
    
    public static function nameLength($value) {
        $result;
	if(strlen($value) > 25) {
            $result = true;
	}
//	elseif(strlen($value) < 4) {
//            $result = true;
//	}
	else {
            $result = false;
	}
	return $result;
    }
    
    public static function passwordLength($value) {
        $result;
	if(strlen($value) > 20) {
            $result = true;
	}
	elseif(strlen($value) < 10) {
            $result = true;
	}
	else {
            $result = false;
	}
	return $result;
    }
    
    public static function validEmail($value) {
        $result;
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    public static function validPostID($value, $value2) {
	$result;
	if(postDB::getPostByPostandAccountID($value, $value2)) {
            $result = true;
	}
	else {
            $result = false;
	}
	return $result;
    }
}
