<?php
/**
 * Description of account
 *
 * @author zekei
 */
class account {
    private $accountID;
    private $username;
    private $email;
    private $accountType;
    private $fname;
    private $lname;
    private $bio;

    public function __construct($accountID, $username, $email, $accountType, $fname, $lname, $bio) {
        $this->accountID = $accountID;
        $this->username = $username;
        $this->email = $email;
        $this->accountType = $accountType;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->bio = $bio;
    }

    public function getAccountID() {
        return $this->accountID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAccountType() {
        return $this->accountType;
    }

    public function getFname() {
        return $this->fname;
    }

    public function getLname() {
        return $this->lname;
    }

    public function getBio() {
        return $this->bio;
    }

    public function setAccountID($accountID): void {
        $this->accountID = $accountID;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setAccountType($accountType): void {
        $this->accountType = $accountType;
    }

    public function setFname($fname): void {
        $this->fname = $fname;
    }

    public function setLname($lname): void {
        $this->lname = $lname;
    }

    public function setBio($bio): void {
        $this->bio = $bio;
    }

}
