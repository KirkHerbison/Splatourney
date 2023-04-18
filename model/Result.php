<?php

class Result {

    private $team_id, $tournament_id, $result;

    public function __construct($team_id, $tournament_id, $result) {
        $this->team_id = $team_id;
        $this->tournament_id = $tournament_id;
        $this->result = $result;
    }

    public function getTeamId() {
        return $this->team_id;
    }

    public function getTournamentId() {
        return $this->tournament_id;
    }

    public function getResult() {
        return $this->result;
    }

    public function setTeamId($team_id) {
        $this->team_id = $team_id;
    }

    public function setTournamentId($tournament_id) {
        $this->tournament_id = $tournament_id;
    }

    public function setResult($result) {
        $this->result = $result;
    }


}
