<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of TeamMemberList
 *
 * @author Kirk
 */
class TeamMemberList {
    
    private $id, $userId, $teamId, $isActive;
    
    public function __construct($id, $userId, $teamId, $isActive) {
        $this->id = $id;
        $this->userId = $userId;
        $this->teamId = $teamId;
        $this->isActive = $isActive;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getTeamId() {
        return $this->teamId;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUserId($user_id) {
        $this->userId = $user_id;
    }

    public function setTeamId($team_id) {
        $this->teamId = $team_id;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }
    
}
