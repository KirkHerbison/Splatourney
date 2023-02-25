<?php

require_once('../model/User.php');
require_once('../model/Tournament.php');
require_once('../model/TournamentType.php');
require_once('../model/TournamentMatch.php');
require_once('../model/Round.php');

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