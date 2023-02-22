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
class Team {

    private $id, $captain_user_id, $team_captain_name, $team_name, $team_image_link, $isActive;

    public function __construct($id, $captain_user_id, $team_captain_name, $team_name, $team_image_link, $isActive) {
        $this->id = $id;
        $this->team_captain_name = $team_captain_name;
        $this->captain_user_id = $captain_user_id;
        $this->team_name = $team_name;
        $this->team_image_link = $team_image_link;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getCaptainUserId() {
        return $this->captain_user_id;
    }

    public function getTeamName() {
        return $this->team_name;
    }

    public function getTeamImageLink() {
        return $this->team_image_link;
    }

    public function getIsActive() {
        return $this->isActive;
    }
    
    
    public function getTeamCaptainName() {
        return $this->team_captain_name;
    }
    
    public function setTeamCaptainName($team_captain_name) {
        $this->team_captain_name = $team_captain_name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCaptainUserId($captain_user_id) {
        $this->captain_user_id = $captain_user_id;
    }

    public function setTeamName($team_name) {
        $this->team_name = $team_name;
    }

    public function setTeamImageLink($team_image_link) {
        $this->team_image_link = $team_image_link;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}
