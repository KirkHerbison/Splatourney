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
class Chat {

    private $id, $matchId, $isActive;

    public function __construct($id, $matchId, $isActive) {
        $this->id = $id;
        $this->matchId = $matchId;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getMatchId() {
        return $this->matchId;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMatchId($matchId) {
        $this->matchId = $matchId;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }


}
