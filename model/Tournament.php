<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Tournament
 *
 * @author Kirk
 */
class Tournament {

    private $id, $tournament_owner_id, $tournament_organizer_name, $tournament_type_id, $tournament_banner_link, $tournament_name, $tournament_date, $tournament_registration_deadline, $tournament_about, $tournament_prizes, $tournament_contact, $tournament_rules, $isActive;

    public function __construct($id, $tournament_owner_id, $tournament_organizer_name, $tournament_type_id, $tournament_banner_link, $tournament_name, $tournament_date, $tournament_registration_deadline, $tournament_about, $tournament_prizes, $tournament_contact, $tournament_rules, $isActive) {
        $this->id = $id;
        $this->tournament_owner_id = $$tournament_owner_id;
        $this->tournament_organizer_name = $tournament_organizer_name;
        $this->tournament_type_id = $tournament_type_id;
        $this->tournament_banner_link = $tournament_banner_link;
        $this->tournament_name = $tournament_name;
        $this->tournament_date = $tournament_date;
        $this->tournament_registration_deadline = $tournament_registration_deadline;
        $this->tournament_about = $tournament_about;
        $this->tournament_prizes = $tournament_prizes;
        $this->tournament_contact = $tournament_contact;
        $this->tournament_rules = $tournament_rules;
        $this->isActive = $isActive;
    }

    public function getId() {
        return $this->id;
    }

    public function getTournamentOwnerId() {
        return $this->tournament_owner_id;
    }

    public function getTournamentOrganizerName() {
        return $this->tournament_organizer_name;
    }

    public function getTournamentTypeId() {
        return $this->tournament_type_id;
    }

    public function getTournamentBannerLink() {
        return $this->tournament_banner_link;
    }

    public function getTournamentName() {
        return $this->tournament_name;
    }

    public function getTournamentDate() {
        return $this->tournament_date;
    }

    public function getTournamentRegistrationDeadline() {
        return $this->tournament_registration_deadline;
    }

    public function getTournamentAbout() {
        return $this->tournament_about;
    }

    public function getTournamentPrizes() {
        return $this->tournament_prizes;
    }

    public function getTournamentContact() {
        return $this->tournament_contact;
    }

    public function getTournamentRules() {
        return $this->tournament_rules;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTournamentOwnerId($tournament_owner_id) {
        $this->tournament_owner_id = $tournament_owner_id;
    }

    public function setTournamentOrganizerName($tournament_organizer_name) {
        $this->tournament_organizer_name = $tournament_organizer_name;
    }

    public function setTournamentTypeId($tournament_type_id) {
        $this->tournament_type_id = $tournament_type_id;
    }

    public function setTournamentBannerLink($tournament_banner_link) {
        $this->tournament_banner_link = $tournament_banner_link;
    }

    public function setTournamentName($tournament_name) {
        $this->tournament_name = $tournament_name;
    }

    public function setTournamentDate($tournament_date) {
        $this->tournament_date = $tournament_date;
    }

    public function setTournamentRegistrationDeadline($tournament_registration_deadline) {
        $this->tournament_registration_deadline = $tournament_registration_deadline;
    }

    public function setTournamentAbout($tournament_about) {
        $this->tournament_about = $tournament_about;
    }

    public function setTournamentPrizes($tournament_prizes) {
        $this->tournament_prizes = $tournament_prizes;
    }

    public function setTournamentContact($tournament_contact) {
        $this->tournament_contact = $tournament_contact;
    }

    public function setTournamentRules($tournament_rules) {
        $this->tournament_rules = $tournament_rules;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}
