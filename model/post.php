<?php
class post {
    private $postID;
    private $accountID;
    private $title;
    private $message;
    private $imgLocation;
    private $privacySetting;
    private $postDate;
    
    public function __construct($postID, $accountID, $title, $message, $imgLocation, $privacySetting, $postDate) {
        $this->postID = $postID;
        $this->accountID = $accountID;
        $this->title = $title;
        $this->message = $message;
        $this->imgLocation = $imgLocation;
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

    public function getImgLocation() {
        return $this->imgLocation;
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

    public function setImgLocation($imgLocation): void {
        $this->imgLocation = $imgLocation;
    }

    public function setPrivacySetting($privacySetting): void {
        $this->privacySetting = $privacySetting;
    }

    public function setPostDate($postDate): void {
        $this->postDate = $postDate;
    }

}
