<?php

class postDB {

    public static function addPost($accountID, $title, $message, $privacysetting) {
        $db = dbh::getDB();
        $query = ('INSERT INTO post (accountID, title, message, privacySetting) VALUES (:accountID, :title, :message, :privacySetting)');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountID', $accountID);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':privacySetting', $privacysetting);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
    }

    public static function removePost($postID) {
        $db = dbh::getDB();
        $query = ('DELETE FROM post WHERE postID = :postid');
        $statement = $db->prepare($query);
        $statement->bindValue(':postid', $postID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
    }
    
    public static function updatePost($postID, $title, $message, $privacysetting, $postUpdate) {
        $db = dbh::getDB();
        $query = ('UPDATE post SET title = :title, message = :message, privacySetting = :privacySetting, postUpdate = :postupdate WHERE postID = :postid');
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':privacySetting', $privacysetting);
        $statement->bindValue(':postupdate', $postUpdate);
        $statement->bindValue(':postid', $postID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $statement->closeCursor();
    } 
    
    public static function getPostByTitle($title) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE title = :title');
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
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

    public static function getAllPosts() {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE ORDER BY postDate desc');
        $statement = $db->prepare($query);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetchAll();
        $statement->closeCursor();
        return $row;
    }
    
    public static function getAllPublicPosts() {
        $privacySetting = "public";
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE privacySetting = :privacySetting ORDER BY postDate desc');
        $statement = $db->prepare($query);
        $statement->bindValue(':privacySetting', $privacySetting);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetchAll();
        $statement->closeCursor();
        return $row;
    }

    public static function getPostsByAccountID($accountID) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE accountID = :accountid ORDER BY postDate desc');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetchAll();
        $statement->closeCursor();
        return $row;
    }

    public static function getPostByPostID($postID) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE postID = :postid');
        $statement = $db->prepare($query);
        $statement->bindValue(':postid', $postID);
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
   
    public static function getPostByPostandAccountID($postID, $accountID) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE postID = :postid AND accountID = :accountid');
        $statement = $db->prepare($query);
        $statement->bindValue(':postid', $postID);
        $statement->bindValue(':accountid', $accountID);
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
    
    public static function checkPostsByAccountID($accountID) {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE accountID = :accountid ORDER BY postDate desc');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
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
    
}
