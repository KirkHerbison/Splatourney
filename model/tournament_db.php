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




function check_team_exists_in_tournament($team_id, $tournament_id) {
    $db = Database::getDB();
    $exists = false;

    $query = 'SELECT ID FROM tournament_team
              WHERE team_id = :team_id AND tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':team_id', $team_id);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $team = $statement->fetch();
    $statement->closeCursor();
    
    if($team != null && $team_id != 0){
        $exists = true;
    }

    return $exists;
}









function get_tournament_teams_by_tournament_id($tournament_id) {
    $db = Database::getDB();
    $teamArray = array();

    $query = 'SELECT tt.*, t.ID AS team_ID, t.isActive AS team_isActive,'
            . ' u.ID AS user_ID, u.username, t.team_name, t.team_image_link,'
            . ' t.captain_user_id FROM tournament_team tt'
            . ' JOIN team t ON t.ID = tt.team_id '
            . ' JOIN splatourney_user u ON u.ID = t.captain_user_id'
            . ' WHERE tournament_id = :tournament_id'
            . ' ORDER BY seed ASC';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $teams = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($teams as $team) {
        $teamObject = new Team($team['team_ID'],
                $team['captain_user_id'],
                $team['username'],
                $team['team_name'],
                $team['team_image_link'],
                $team['team_isActive']);
        $teamArray[] = $teamObject;
    }

    return $teamArray;
}





function get_lowest_seed_by_tournament_id($tournament_id) {
    $db = Database::getDB();

    $query = 'SELECT MAX(seed) FROM tournament_team'
            . ' WHERE tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $seed = $statement->fetch();
    $statement->closeCursor();
    return $seed[0];
}








function get_maps() {
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

function get_modes() {
    $db = Database::getDB();
    $modeArray = array();

    $query = 'SELECT * FROM mode';
    $statement = $db->prepare($query);
    $statement->execute();
    $modes = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($modes as $mode) {
        $modeObject = new Map($mode['ID'],
                $mode['description'],
                $mode['image_link']);

        $modeArray[] = $modeObject;
    }

    return $modeArray;
}

function get_map_by_id($id) {
    $db = Database::getDB();

    $query = 'SELECT * FROM map
              WHERE id= :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $map = $statement->fetch();
    $statement->closeCursor();

    $mapObject = new Map($map['ID'],
            $map['description'],
            $map['image_link']);
    return $mapObject;
}

function get_mode_by_id($id) {
    $db = Database::getDB();

    $query = 'SELECT * FROM mode
              WHERE id= :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $mode = $statement->fetch();
    $statement->closeCursor();

    $modeObject = new Map($mode['ID'],
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

function add_tournament_team($seed, $team_id, $tournament_id) {
    $db = Database::getDB();
    $query = 'INSERT INTO tournament_team (seed, team_id, tournament_id)
                VALUES(:seed, :team_id, :tournament_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':seed', $seed);
    $statement->bindValue(':team_id', $team_id);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $statement->closeCursor();
}


function add_tournament($tournament) {
    $db = Database::getDB();
    $query = 'INSERT INTO tournament (tournament_owner_id, tournament_organizer_name, tournament_type_id, tournament_banner_link, tournament_name,tournament_date, tournament_registration_deadline,  tournament_about, tournament_prizes, tournament_contact, tournament_rules, isActive)
                VALUES(:tournament_owner_id, :tournament_organizer_name, :tournament_type_id, COALESCE(:tournament_banner_link, \'default.png\'), :tournament_name, :tournament_date, :tournament_registration_deadline, :tournament_about, :tournament_prizes, :tournament_contact, :tournament_rules, :isActive)';
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

function update_tournament($tournament) {
    $db = Database::getDB();
    $query = 'UPDATE tournament
                SET tournament_organizer_name = :tournament_organizer_name, tournament_type_id = :tournament_type_id, 
                tournament_banner_link = :tournament_banner_link, tournament_name = :tournament_name,tournament_date = :tournament_date, 
                tournament_registration_deadline = :tournament_registration_deadline,  tournament_about = :tournament_about, 
                tournament_prizes = :tournament_prizes, tournament_contact = :tournament_contact, tournament_rules = :tournament_rules        
                WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $tournament->getId());
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
    $statement->execute();
    $statement->closeCursor();

    return $db->lastInsertId();
}

function get_tournaments() {
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

function get_tournaments_by_ownerId($ID) {
    $db = Database::getDB();
    $tournamentArray = array();
    $query = 'SELECT * FROM tournament'
            . ' WHERE tournament_owner_id = :tournament_owner_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_owner_id', $ID);
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

function get_tournaments_team_count_by_tournament_id($ID) {
    $db = Database::getDB();
    $query = 'SELECT COUNT(*) FROM tournament_team'
            . ' WHERE tournament_id = :tournament_id;';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $ID);
    $statement->execute();
    $count = $statement->fetchColumn();
    $statement->closeCursor();
    return $count;
}



function search_tournaments($name) {
    $db = Database::getDB();
    $tournamentArray = array();
    $query = 'SELECT * FROM tournament
                WHERE tournament_name LIKE "%":tournament_name"%"';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_name', $name);
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

function update_tournament_isActive($id, $isActive) {
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

function update_seeding_by_team_id_and_tournament_id($team_id, $tournament_id, $seed) {
    $db = Database::getDB();
    $query = 'UPDATE tournament_team
                     SET seed = :seed
                     WHERE team_id = :team_id AND tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':team_id', $team_id);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->bindValue(':seed', $seed);
    $statement->execute();
    $statement->closeCursor();
}
