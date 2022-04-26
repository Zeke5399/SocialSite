<?php
/**
 * Description of account
 *
 * @author zekei
 */
class account {
    private $accountID;
    private $username;

    public function __construct($accountID, $username) {
        $this->accountID = $accountID;
        $this->username = $username;
    }

    public function getAccountID() {
        return $this->accountID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setAccountID($accountID): void {
        $this->accountID = $accountID;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }
}
