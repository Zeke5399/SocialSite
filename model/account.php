<?php
/**
 * Description of account
 *
 * @author zekei
 */
class account {
    private $accountID;
    private $username;
    private $accountType;
    private $fname;
    private $lname;

    public function __construct($accountID, $username, $accountType, $fname, $lname) {
        $this->accountID = $accountID;
        $this->username = $username;
        $this->accountType = $accountType;
        $this->fname = $fname;
        $this->lname = $lname;
    }

    public function getAccountID() {
        return $this->accountID;
    }

    public function getUsername() {
        return $this->username;
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

    public function setAccountID($accountID): void {
        $this->accountID = $accountID;
    }

    public function setUsername($username): void {
        $this->username = $username;
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
}
