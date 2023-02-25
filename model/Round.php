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
class Round {

    private $roundNumber, $matches;

    public function __construct($roundNumber, $matches) {
        $this->roundNumber = $roundNumber;
        $this->matches = $matches;
    }

    public function getRoundNumber() {
        return $this->roundNumber;
    }

    public function getMatches() {
        return $this->matches;
    }

    public function setRoundNumber($roundNumber) {
        $this->roundNumber = $roundNumber;
    }

    public function setMatches($matches) {
        $this->matches = $matches;
    }

}
