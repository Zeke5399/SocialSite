<?php
class post {
    private $postID;
    private $accountID;
    private $title;
    private $message;
    private $privacySetting;
    private $postDate;
    
    public function __construct($postID, $accountID, $title, $message, $privacySetting, $postDate) {
        $this->postID = $postID;
        $this->accountID = $accountID;
        $this->title = $title;
        $this->message = $message;
        $this->privacySetting = $privacySetting;
        $this->postDate = $postDate;
    }

    public function getPostID() {
        return $this->postID;
    }

    public function getAccountID() {
        return $this->accountID;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getPrivacySetting() {
        return $this->privacySetting;
    }

    public function getPostDate() {
        return $this->postDate;
    }

    public function setPostID($postID): void {
        $this->postID = $postID;
    }

    public function setAccountID($accountID): void {
        $this->accountID = $accountID;
    }

    public function setTitle($title): void {
        $this->title = $title;
    }

    public function setMessage($message): void {
        $this->message = $message;
    }

    public function setPrivacySetting($privacySetting): void {
        $this->privacySetting = $privacySetting;
    }

    public function setPostDate($postDate): void {
        $this->postDate = $postDate;
    }
}
