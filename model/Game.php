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
class Game {

    private $id, $bracketMatchListId, $gameNumber, $mapId, $modeId, $isActive;

    public function __construct($id, $bracketMatchListId, $gameNumber, $mapId, $modeId, $isActive) {
        $this->id = $id;
        $this->bracketMatchListId = $bracketMatchListId;
        $this->gameNumber = $gameNumber;
        $this->mapId = $mapId;
        $this->modeId = $modeId;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getBracketMatchListId() {
        return $this->bracketMatchListId;
    }

    public function getMapId() {
        return $this->mapId;
    }

    public function getModeId() {
        return $this->modeId;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getGameNumber() {
        return $this->gameNumber;
    }

    public function setGameNumber($gameNumber) {
        $this->gameNumber = $gameNumber;
    }
     
    public function setId($id) {
        $this->id = $id;
    }

    public function setBracketMatchListId($bracketMatchListId) {
        $this->bracketMatchListId = $bracketMatchListId;
    }

    public function setMapId($mapId) {
        $this->mapId = $mapId;
    }

    public function setModeId($modeId) {
        $this->modeId = $modeId;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }
}
