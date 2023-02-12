<?php

require_once('../model/User.php');
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

function get_tournament_by_name_and_date() {
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
