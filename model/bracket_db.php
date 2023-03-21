<?php

require_once('../model/User.php');
require_once('../model/Tournament.php');
require_once('../model/TournamentType.php');
require_once('../model/TournamentMatch.php');
require_once('../model/Round.php');
require_once('../model/Bracket.php');

function get_matches_by_round_number($number, $tournament_id) {
    $db = Database::getDB();
    $matchArray = array();

    $query = 'SELECT * FROM tournament_match
              WHERE round = :round AND tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':round', $number);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $matches = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($matches as $match) {
        $matchObject = new TournamentMatch($match['ID'],
                $match['tournament_id'],
                $match['team_one_id'],
                $match['team_two_id'],
                $match['round'],
                $match['team_one_wins'],
                $match['team_two_wins'],
                $match['winner_team_id'],
                $match['match_number'],
                $match['isActive']);
        $matchArray[] = $matchObject;
    }
    return $matchArray;
}

function get_matche_by_id($ID) {
    $db = Database::getDB();
    
    $query = 'SELECT * FROM tournament_match
              WHERE ID = :ID';
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();
    $match = $statement->fetch();
    $statement->closeCursor();

    $matchObject = new TournamentMatch($match['ID'],
            $match['tournament_id'],
            $match['team_one_id'],
            $match['team_two_id'],
            $match['round'],
            $match['team_one_wins'],
            $match['team_two_wins'],
            $match['winner_team_id'],
            $match['match_number'],
            $match['isActive']);
    return $matchObject;
}

function addTeamOneWin($ID) {
    $db = Database::getDB();
    $query = 'UPDATE tournament_match
                     SET team_one_wins = (team_one_wins + 1)
                     WHERE ID = :ID';
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();
    $statement->closeCursor();
}

function addTeamTwoWin($ID) {
    $db = Database::getDB();
    $query = 'UPDATE tournament_match
                     SET team_two_wins = (team_two_wins + 1)
                     WHERE ID = :ID';
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();
    $statement->closeCursor();
}

function check_round_exists_by_number($number, $tournament_id) {
    $db = Database::getDB();
    $exists = false;

    $query = 'SELECT round, tournament_id FROM tournament_match
              WHERE round = :round AND tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':round', $number);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $matches = $statement->fetch();
    $statement->closeCursor();
    
    if($matches != null){
        $exists = true;
    }

    return $exists;
}

function get_brackets_by_tournament_id($tournament_id) {
    $db = Database::getDB();
    $bracketArray = array();

    $query = 'SELECT * FROM tournament_bracket
              WHERE tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $brackets = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($brackets as $bracket) {
        $bracketObject = new Bracket($bracket['ID'],
                $bracket['tournament_id'],
                $bracket['tournament_type_id'],
                $bracket['tournament_bracket_name']);
        $bracketArray[] = $bracketObject;
    }
    return $bracketArray;
}

function insert_bracket($bracket) {
    $db = Database::getDB();
    $query = 'INSERT INTO tournament_bracket (tournament_id, tournament_type_id, tournament_bracket_name)
                VALUES(:tournament_id, :tournament_type_id, :tournament_bracket_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $bracket->getTournamentId());
    $statement->bindValue(':tournament_type_id',$bracket->getTournamentTypeId());
    $statement->bindValue(':tournament_bracket_name', $bracket->getTournamentBracketName());
    $statement->execute();
    $statement->closeCursor();
    
    return $db->lastInsertId();
}

function insert_match($bracket, $round) {
    $db = Database::getDB();
    $query = 'INSERT INTO tournament_match (tournament_id, tournament_bracket_id, round)
                VALUES(:tournament_id, :tournament_bracket_id, :round)';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $bracket->getTournamentId());
    $statement->bindValue(':tournament_bracket_id',$bracket->getId());
    $statement->bindValue(':round', $round);
    $statement->execute();
    $statement->closeCursor();
    
    return $db->lastInsertId();
}