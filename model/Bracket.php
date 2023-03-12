<?php

class Bracket {

    private $id, $tournamentId, $tournamentTypeId, $tournamentBracketName;

    public function __construct($id, $tournamentId, $tournamentTypeId, $tournamentBracketName) {
        $this->id = $id;
        $this->tournamentId = $tournamentId;
        $this->tournamentTypeId = $tournamentTypeId;
        $this->tournamentBracketName = $tournamentBracketName;
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
