<?php

class MapList {

    private $id, $bracket_id, $round, $isActive;

    public function __construct($id, $bracket_id, $round, $isActive) {
        $this->id = $id;
        $this->bracket_id = $bracket_id;
        $this->round = $round;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getBracketId() {
        return $this->bracket_id;
    }

    public function getRound() {
        return $this->round;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setBracketId($bracket_id) {
        $this->bracket_id = $bracket_id;
    }

    public function setRound($round) {
        $this->round = $round;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }
    
}
