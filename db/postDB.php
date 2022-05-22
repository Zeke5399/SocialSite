<?php

class postDB {

    public static function addPost($accountID, $title, $message, $imgLocation, $privacysetting) {
        $db = dbh::getDB();
        $query = ('INSERT INTO post (accountID, title, message, imgLocation, privacySetting) VALUES (:accountID, :title, :message, :imglocation, :privacySetting)');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountID', $accountID);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':imglocation', $imgLocation);
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

    public static function removeAllPostsByAccountID($accountID) {
        $db = dbh::getDB();
        $query = ('DELETE FROM post WHERE accountID = :accountid');
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

    public static function updatePost($postID, $title, $message, $imgLocation, $privacysetting, $postUpdate) {
        $db = dbh::getDB();
        $query = ('UPDATE post SET title = :title, message = :message, imgLocation = :imglocation, privacySetting = :privacySetting, postUpdate = :postupdate WHERE postID = :postid');
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':imglocation', $imgLocation);
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

    public static function getAllPublicPostsByPage($currentPage, $itemsPerPage) {
        $fetchStart = ($currentPage - 1) * $itemsPerPage;
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
        $filteredRow = array_slice($row, $fetchStart, $itemsPerPage);
        $statement->closeCursor();
        return $filteredRow;
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

    public static function getPublicPostsByAccountID($accountID) {
        $privacySetting = "public";
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE accountID = :accountid AND privacySetting = :privacySetting ORDER BY postDate desc');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
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

    public static function getPublicPostsByAccountIDByPage($accountID, $currentPage, $itemsPerPage) {
        $fetchStart = ($currentPage - 1) * $itemsPerPage;
        $privacySetting = "public";
        $db = dbh::getDB();
        $query = ('SELECT * FROM post WHERE accountID = :accountid AND privacySetting = :privacySetting ORDER BY postDate desc');
        $statement = $db->prepare($query);
        $statement->bindValue(':accountid', $accountID);
        $statement->bindValue(':privacySetting', $privacySetting);
        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetchAll();
        $filteredRow = array_slice($row, $fetchStart, $itemsPerPage);
        $statement->closeCursor();
        return $filteredRow;
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
        if ($statement->rowCount() > 0) {
            $resultCheck = true;
        } else {
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
        if ($statement->rowCount() > 0) {
            $resultCheck = true;
        } else {
            $resultCheck = false;
        }
        $statement->closeCursor();
        return $resultCheck;
    }

    public static function getPostsByFilter($title, $postDate, $beforeAfter) {
        $method = null;
        if ($beforeAfter == "before") {
            $method = "<";
        } elseif ($beforeAfter == "after") {
            $method = ">";
        }
        $db = dbh::getDB();
        $query = ('SELECT * FROM post');

        if ($title != "" and $postDate != "") {
            $query .= ' WHERE title LIKE :title AND postDate ' . $method . ' :postdate';
            $title = "%" . $title . "%";
        } elseif ($title != "") {
            $query .= ' WHERE title LIKE :title';
            $title = "%" . $title . "%";
        } elseif ($postDate != "") {
            $query .= ' WHERE postDate ' . $method . ' :postdate';
        }

        if ($beforeAfter == "after") {
            $query .= ' ORDER BY postDate asc';
        } else {
            $query .= ' ORDER BY postDate desc';
        }

        $statement = $db->prepare($query);

        if ($title != "") {
            $statement->bindValue(':title', $title);
        }
        if ($postDate != "") {
            $statement->bindValue(':postdate', $postDate);
        }

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

    public static function getPostsByFilterByPage($title, $postDate, $beforeAfter, $currentPage, $itemsPerPage) {
        $fetchStart = ($currentPage - 1) * $itemsPerPage;
        $method = null;
        if ($beforeAfter == "before") {
            $method = "<";
        } elseif ($beforeAfter == "after") {
            $method = ">";
        }
        $db = dbh::getDB();
        $query = ('SELECT * FROM post');

        if ($title != "" and $postDate != "") {
            $query .= ' WHERE title LIKE :title AND postDate ' . $method . ' :postdate';
            $title = "%" . $title . "%";
        } elseif ($title != "") {
            $query .= ' WHERE title LIKE :title';
            $title = "%" . $title . "%";
        } elseif ($postDate != "") {
            $query .= ' WHERE postDate ' . $method . ' :postdate';
        }

        if ($beforeAfter == "after") {
            $query .= ' ORDER BY postDate asc';
        } else {
            $query .= ' ORDER BY postDate desc';
        }
        
        $statement = $db->prepare($query);

        if ($title != "") {
            $statement->bindValue(':title', $title);
        }
        if ($postDate != "") {
            $statement->bindValue(':postdate', $postDate);
        }

        try {
            $statement->execute();
        } catch (Exception $e) {
            include('./errors/dbError.php');
            exit();
        }
        $row = $statement->fetchAll();
        $filteredRow = array_slice($row, $fetchStart, $itemsPerPage);
        $statement->closeCursor();
        return $filteredRow;
    }

}
