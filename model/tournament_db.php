<?php

require_once('../model/User.php');
require_once('../model/Map.php');
require_once('../model/Tournament.php');
require_once('../model/TournamentType.php');

function get_tournament_types() {
    $db = Database::getDB();
    $tournamentTypeArray = array();

    $query = 'SELECT * FROM tournament_type';
    $statement = $db->prepare($query);
    $statement->execute();
    $tournamentTypes = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($tournamentTypes as $tournamentType) {
        $tournamentObject = new TournamnetType($tournamentType['ID'],
                $tournamentType['description'],
                $tournamentType['isActive']);

        $tournamentTypeArray[] = $tournamentObject;
    }

    return $tournamentTypeArray;
}

function get_maps(){
    $db = Database::getDB();
    $mapArray = array();

    $query = 'SELECT * FROM map';
    $statement = $db->prepare($query);
    $statement->execute();
    $maps = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($maps as $map) {
        $mapObject = new Map($map['ID'],
                $map['description'],
                $map['image_link']);

        $mapArray[] = $mapObject;
    }

    return $mapArray;
}

function get_map_by_id($id){
    $db = Database::getDB();

    $query = 'SELECT * FROM map
              WHERE id= :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $map = $statement->fetch();
    $statement->closeCursor();

    $mapObject= new Map($map['ID'],
                $map['description'],
                $map['image_link']);
    return $mapObject;
}

function get_mode_by_id($id){
    $db = Database::getDB();

    $query = 'SELECT * FROM mode
              WHERE id= :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $mode = $statement->fetch();
    $statement->closeCursor();

    $modeObject= new Map($mode['ID'],
                $mode['description'],
                $mode['image_link']);
    return $modeObject;
}



function get_tournament_by_id($id) {
    $db = Database::getDB();

    $query = 'SELECT * FROM tournament
              WHERE id= :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $tournament = $statement->fetch();
    $statement->closeCursor();
    $tournamentObject = new Tournament($tournament['ID'],
                $tournament['tournament_owner_id'],
                $tournament['tournament_organizer_name'],
                $tournament['tournament_type_id'],
                $tournament['tournament_banner_link'],
                $tournament['tournament_name'],
                $tournament['tournament_date'],
                $tournament['tournament_registration_deadline'],
                $tournament['tournament_about'],
                $tournament['tournament_prizes'],
                $tournament['tournament_contact'],
                $tournament['tournament_rules'],
                $tournament['isActive']);
    return $tournamentObject;
}

function add_tournament($tournament) {
    $db = Database::getDB();
    $query = 'INSERT INTO tournament (tournament_owner_id, tournament_organizer_name, tournament_type_id, tournament_banner_link, tournament_name,tournament_date, tournament_registration_deadline,  tournament_about, tournament_prizes, tournament_contact, tournament_rules, isActive)
                VALUES(:tournament_owner_id, :tournament_organizer_name, :tournament_type_id, :tournament_banner_link, :tournament_name, :tournament_date, :tournament_registration_deadline, :tournament_about, :tournament_prizes, :tournament_contact, :tournament_rules, :isActive)';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_owner_id', $tournament->getTournamentOwnerId());
    $statement->bindValue(':tournament_organizer_name', $tournament->getTournamentOrganizerName());
    $statement->bindValue(':tournament_type_id', $tournament->getTournamentTypeId());
    $statement->bindValue(':tournament_banner_link', $tournament->getTournamentBannerLink());
    $statement->bindValue(':tournament_name', $tournament->getTournamentName());
    $statement->bindValue(':tournament_date', $tournament->getTournamentDate());
    $statement->bindValue(':tournament_registration_deadline', $tournament->getTournamentRegistrationDeadline());
    $statement->bindValue(':tournament_about', $tournament->getTournamentAbout());
    $statement->bindValue(':tournament_prizes', $tournament->getTournamentPrizes());
    $statement->bindValue(':tournament_contact', $tournament->getTournamentContact());
    $statement->bindValue(':tournament_rules', $tournament->getTournamentRules());
    $statement->bindValue(':isActive', $tournament->getIsActive());
    $statement->execute();
    $statement->closeCursor();

    return $db->lastInsertId();
}

function edit_tournament($tournament) {
    $db = Database::getDB();
    $query = 'UPDATE tournament
                SET tournament_organizer_name = :tournament_organizer_name, tournament_type_id = :tournament_type_id, tournament_banner_link = :tournament_banner_link, tournament_name = :tournament_name,tournament_date = :tournament_date, tournament_registration_deadline = :tournament_registration_deadline,  tournament_about = :tournament_about, tournament_prizes = :tournament_prizes, tournament_contact = :tournament_contact, tournament_rules = :tournament_rules
                WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $tournament->getId());
    $statement->bindValue(':tournament_owner_id', $tournament->getTournamentOwnerId());
    $statement->bindValue(':tournament_organizer_name', $tournament->getTournamentOrganizerName());
    $statement->bindValue(':tournament_type_id', $tournament->getTournamentTypeId());
    $statement->bindValue(':tournament_banner_link', $tournament->getTournamentBannerLink());
    $statement->bindValue(':tournament_name', $tournament->getTournamentName());
    $statement->bindValue(':tournament_date', $tournament->getTournamentDate());
    $statement->bindValue(':tournament_registration_deadline', $tournament->getTournamentRegistrationDeadline());
    $statement->bindValue(':tournament_about', $tournament->getTournamentAbout());
    $statement->bindValue(':tournament_prizes', $tournament->getTournamentPrizes());
    $statement->bindValue(':tournament_contact', $tournament->getTournamentContact());
    $statement->bindValue(':tournament_rules', $tournament->getTournamentRules());
    $statement->bindValue(':isActive', $tournament->getIsActive());
    $statement->execute();
    $statement->closeCursor();

    return $db->lastInsertId();
}

function get_tournaments(){
    $db = Database::getDB();
    $tournamentArray = array();
    $query = 'SELECT * FROM tournament';
    $statement = $db->prepare($query);
    $statement->execute();
    $tournaments = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($tournaments as $tournament) {
        $tournamentObject = new Tournament($tournament['ID'],
                $tournament['tournament_owner_id'],
                $tournament['tournament_organizer_name'],
                $tournament['tournament_type_id'],
                $tournament['tournament_banner_link'],
                $tournament['tournament_name'],
                $tournament['tournament_date'],
                $tournament['tournament_registration_deadline'],
                $tournament['tournament_about'],
                $tournament['tournament_prizes'],
                $tournament['tournament_contact'],
                $tournament['tournament_rules'],
                $tournament['isActive']);
        $tournamentArray[] = $tournamentObject;
    }
    return $tournamentArray;
}

function update_tournament_isActive($id, $isActive){
    $db = Database::getDB();
    $query = 'UPDATE tournament
                     SET isActive = :isActive
                     WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':isActive', $isActive);
    $statement->execute();
    $statement->closeCursor();
}