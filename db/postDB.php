<?php
class postDB {
    public static function addPost($accountID, $title, $message, $privacysetting)
    {
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
    
    public static function getPosts() {
        $db = dbh::getDB();
        $query = ('SELECT * FROM post');
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
    
}
