<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TournamentMatch
 *
 * @author Kirk
 */
class BracketMatch {

    private $id, $tournament_id, $bracket_id, $team_one_id, $team_two_id, $round, $team_one_wins, $team_two_wins, $winner_team_id, $match_number, $isActive;

    public function __construct($id, $tournament_id, $bracket_id, $team_one_id, $team_two_id, $round, $team_one_wins, $team_two_wins, $winner_team_id, $match_number, $isActive) {
        $this->id = $id;
        $this->tournament_id = $tournament_id;
        $this->bracket_id = $bracket_id;
        $this->team_one_id = $team_one_id;
        $this->team_two_id = $team_two_id;
        $this->round = $round;
        $this->team_one_wins = $team_one_wins;
        $this->team_two_wins = $team_two_wins;
        $this->winner_team_id = $winner_team_id;
        $this->match_number = $match_number;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getTournamentId() {
        return $this->tournament_id;
    }

    public function getTeamOneId() {
        return $this->team_one_id;
    }

    public function getTeamTwoId() {
        return $this->team_two_id;
    }

    public function getRound() {
        return $this->round;
    }

    public function getTeamOneWins() {
        return $this->team_one_wins;
    }

    public function getTeamTwoWins() {
        return $this->team_two_wins;
    }

    public function getWinnerTeamId() {
        return $this->winner_team_id;
    }

    public function getMatchNumber() {
        return $this->match_number;
    }

    public function getIsActive() {
        return $this->isActive;
    }
    
    public function getBracketId() {
        return $this->bracket_id;
    }

    public function setBracketId($bracket_id) {
        $this->bracket_id = $bracket_id;
    }

    
    public function setId($id) {
        $this->id = $id;
    }

    public function setTournamentId($tournament_id) {
        $this->tournament_id = $tournament_id;
    }

    public function setTeamOneId($team_one_id) {
        $this->team_one_id = $team_one_id;
    }

    public function setTeamTwoId($team_two_id) {
        $this->team_two_id = $team_two_id;
    }

    public function setRound($round) {
        $this->round = $round;
    }

    public function setTeamOneWins($team_one_wins) {
        $this->team_one_wins = $team_one_wins;
    }

    public function setTeamTwoWns($team_two_wins) {
        $this->team_two_wins = $team_two_wins;
    }

    public function setWinnerTeamId($winner_team_id) {
        $this->winner_team_id = $winner_team_id;
    }

    public function setMatchNumber($match_number) {
        $this->match_number = $match_number;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}
