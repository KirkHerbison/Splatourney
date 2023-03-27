<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Team
 *
 * @author Kirk
 */
class Chat_Message {

    private $id, $chatId, $userId, $message, $dateSent;

    public function __construct($id, $chatId, $userId, $message, $dateSent) {
        $this->id = $id;
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->message = $message;
        $this->dateSent = $dateSent;
    }

    public function getId() {
        return $this->id;
    }

    public function getChatId() {
        return $this->chatId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getDateSent() {
        return $this->dateSent;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setChatId($chatId) {
        $this->chatId = $chatId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setDateSent($dateSent) {
        $this->dateSent = $dateSent;
    }

}
