<?php

class Bracket {

    private $id, $tournamentId, $tournamentTypeId, $tournamentBracketName, $numberOfRounds;

    public function __construct($id, $tournamentId, $tournamentTypeId, $tournamentBracketName, $numberOfRounds) {
        $this->id = $id;
        $this->tournamentId = $tournamentId;
        $this->tournamentTypeId = $tournamentTypeId;
        $this->tournamentBracketName = $tournamentBracketName;
        $this->numberOfRounds = $numberOfRounds;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTournamentId() {
        return $this->tournamentId;
    }

    public function getTournamentTypeId() {
        return $this->tournamentTypeId;
    }

    public function getTournamentBracketName() {
        return $this->tournamentBracketName;
    }
    
    public function getNumberOfRounds() {
        return $this->numberOfRounds;
    }

    public function setNumberOfRounds($numberOfRounds) {
        $this->numberOfRounds = $numberOfRounds;
    }

    
    public function setId($id) {
        $this->id = $id;
    }

    public function setTournamentId($tournamentId) {
        $this->tournamentId = $tournamentId;
    }

    public function setTournamentTypeId($tournamentTypeId) {
        $this->tournamentTypeId = $tournamentTypeId;
    }

    public function setTournamentBracketName($tournament_bracket_name) {
        $this->tournamentBracketName = $tournament_bracket_name;
    }



}

