<?php

require_once('../model/User.php');
require_once('../model/Tournament.php');
require_once('../model/TournamentType.php');
require_once('../model/BracketMatch.php');
require_once('../model/Round.php');
require_once('../model/Bracket.php');
require_once('../model/Game.php');
require_once('../model/Chat.php');
require_once('../model/Chat_Message.php');

function get_matches_by_round_number($number, $bracket_id) {
    $db = Database::getDB();
    $matchArray = array();

    $query = 'SELECT * FROM bracket_match
              WHERE round = :round AND bracket_id = :bracket_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':round', $number);
    $statement->bindValue(':bracket_id', $bracket_id);
    $statement->execute();
    $matches = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($matches as $match) {
        $matchObject = new BracketMatch($match['ID'],
                $match['tournament_id'],
                $match['bracket_id'],
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

function get_match_by_id($ID) {
    $db = Database::getDB();
    
    $query = 'SELECT * FROM bracket_match
              WHERE ID = :ID';
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();
    $match = $statement->fetch();
    $statement->closeCursor();

    $matchObject = new BracketMatch($match['ID'],
            $match['tournament_id'],
            $match['bracket_id'],
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

function get_matches_by_tournament_id($ID) {
    $db = Database::getDB();
    $matchArray = array();

    $query = 'SELECT * FROM bracket_match
              WHERE tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $ID);
    $statement->execute();
    $matches = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($matches as $match) {
        $matchObject = new BracketMatch($match['ID'],
                $match['tournament_id'],
                $match['bracket_id'],
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

function insert_message_by_chat_id($message){
    $db = Database::getDB();
    $query = 'INSERT INTO chat_message (chat_id, user_id, message)
                VALUES(:chat_id, :user_id, :message)';
    $statement = $db->prepare($query);
    $statement->bindValue(':chat_id', $message->getChatId());
    $statement->bindValue(':user_id',$message->getUserId());
    $statement->bindValue(':message', $message->getMessage());
    $statement->execute();
    $statement->closeCursor();
}

function update_maplist_game($bracket_match_list_id, $game_number, $map_id, $mode_id){
        $db = Database::getDB();
    $query = 'UPDATE bracket_map_list_map
                     SET map_id = :map_id, mode_id  = :mode_id
                     WHERE bracket_match_list_id = :bracket_match_list_id AND game_number = :game_number';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_match_list_id', $bracket_match_list_id);
    $statement->bindValue(':game_number', $game_number);
    $statement->bindValue(':map_id', $map_id);
    $statement->bindValue(':mode_id', $mode_id);
    $statement->execute();
    $statement->closeCursor();
}


function insert_bracket_by_tournament_id($tournament_id){
    $db = Database::getDB();
    $query = 'INSERT INTO bracket (tournament_id)
                VALUES(:tournament_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $statement->closeCursor();
}

function  insert_bracket_map_list_by_round_and_bracket_id($bracket_id, $round, $isActive){
    $db = Database::getDB();
    $query = 'INSERT INTO bracket_map_list (bracket_id, round, isActive)
                VALUES(:bracket_id, :round, :isActive)';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_id', $bracket_id);
    $statement->bindValue(':round', $round);
    $statement->bindValue(':isActive', $isActive);
    $statement->execute();
    $statement->closeCursor();
    
    return $db->lastInsertId();
}


function insert_map_list_map_by_map_list_id_and_game_number($map_list_id, $game_number, $isActive){
        $db = Database::getDB();
    $query = 'INSERT INTO bracket_map_list_map (bracket_match_list_id, game_number, isActive)
                VALUES(:bracket_match_list_id, :game_number, :isActive)';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_match_list_id', $map_list_id);
    $statement->bindValue(':game_number', $game_number);
    $statement->bindValue(':isActive', $isActive);
    $statement->execute();
    $statement->closeCursor();
}






function addTeamOneWin($ID) {
    $db = Database::getDB();
    $query = 'UPDATE bracket_match
                     SET team_one_wins = (team_one_wins + 1)
                     WHERE ID = :ID';
    $statement = $db->prepare($query);
    $statement->bindValue(':ID', $ID);
    $statement->execute();
    $statement->closeCursor();
    
}

function addTeamTwoWin($ID) {
    $db = Database::getDB();
    $query = 'UPDATE bracket_match
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

    $query = 'SELECT round, tournament_id FROM bracket_match
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

function get_bracket_by_tournament_id($tournament_id) {
    $db = Database::getDB();

    $query = 'SELECT * FROM bracket
              WHERE tournament_id = :tournament_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $tournament_id);
    $statement->execute();
    $bracket = $statement->fetch();
    $statement->closeCursor();
    $bracketObject = new Bracket($bracket['ID'],
            $bracket['tournament_id'],
            $bracket['tournament_type_id'],
            $bracket['bracket_name'],
            $bracket['number_of_rounds']);
    return $bracketObject;
}

function get_bracket_map_lists_by_bracket_id($bracket_id) {
    $db = Database::getDB();
    $mapListArray = array();

    $query = 'SELECT * FROM bracket_map_list
              WHERE bracket_id = :bracket_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_id', $bracket_id);
    $statement->execute();
    $mapLists = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($mapLists as $mapList) {
        $mapListObject = new MapList($mapList['ID'],
                $mapList['bracket_id'],
                $mapList['round'],
                $mapList['isActive']);
        $mapListArray[] = $mapListObject;
    }
    return $mapListArray;
}

function get_bracket_map_list_by_round_and_bracket_id($bracket_id, $round) {
    $db = Database::getDB();

    $query = 'SELECT * FROM bracket_map_list
              WHERE bracket_id = :bracket_id AND round = :round';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_id', $bracket_id);
    $statement->bindValue(':round', $round);
    $statement->execute();
    $mapList = $statement->fetch();
    $statement->closeCursor();

    $mapListObject = new MapList($mapList['ID'],
        $mapList['bracket_id'],
        $mapList['round'],
        $mapList['isActive']);
    return $mapListObject;
}




function get_match_games_by_id($bracket_match_list_id) {
    $db = Database::getDB();
    $gameArray = array();

    $query = 'SELECT * FROM bracket_map_list_map
              WHERE bracket_match_list_id = :bracket_match_list_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_match_list_id', $bracket_match_list_id);
    $statement->execute();
    $games = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($games as $game) {
        $gameObject = new Game($game['ID'],
                $game['bracket_match_list_id'],
                $game['game_number'],
                $game['map_id'],
                $game['mode_id'],
                $game['isActive']);
        $gameArray[] = $gameObject;
    }
    return $gameArray;
}

function get_messages_by_chat_id($chat_id) {
    $db = Database::getDB();
    $messageArray = array();

    $query = 'SELECT * FROM chat_message
              WHERE chat_id = :chat_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':chat_id', $chat_id);
    $statement->execute();
    $messages = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($messages as $message) {
        $messageObject = new Chat_Message($message['ID'],
                $message['chat_id'],
                $message['user_id'],
                $message['message'],
                $message['date_sent']);
        $messageArray[] = $messageObject;
    }
    return $messageArray;
}

function get_chat_by_match_id($match_id) {
    $db = Database::getDB();
    $query = 'SELECT * FROM chat
              WHERE match_id = :match_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':match_id', $match_id);
    $statement->execute();
    $chat = $statement->fetch();
    $statement->closeCursor();
    $chatObject = new Chat($chat['ID'],
        $chat['match_id'],
        $chat['isActive']);
    return $chatObject;
}





function get_map_image_link_by_id($id) {
    $db = Database::getDB();

    $query = 'SELECT image_link FROM map
              WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $map = $statement->fetch();
    $statement->closeCursor();

    return $map['image_link'];
}


function get_mode_image_link_by_id($id) {
    $db = Database::getDB();

    $query = 'SELECT image_link FROM mode
              WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $mode = $statement->fetch();
    $statement->closeCursor();

    return $mode['image_link'];
}









function insert_bracket($bracket) {
    $db = Database::getDB();
    $query = 'INSERT INTO bracket (tournament_id, tournament_type_id, bracket_name)
                VALUES(:tournament_id, :tournament_type_id, :bracket_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $bracket->getTournamentId());
    $statement->bindValue(':tournament_type_id',$bracket->getTournamentTypeId());
    $statement->bindValue(':bracket_name', $bracket->getBracketName());
    $statement->execute();
    $statement->closeCursor();
    
    return $db->lastInsertId();
}

function insert_match($bracket, $round) {
    $db = Database::getDB();
    $query = 'INSERT INTO bracket_match (tournament_id, bracket_id, round)
                VALUES(:tournament_id, :bracket_id, :round)';
    $statement = $db->prepare($query);
    $statement->bindValue(':tournament_id', $bracket->getTournamentId());
    $statement->bindValue(':bracket_id',$bracket->getId());
    $statement->bindValue(':round', $round);
    $statement->execute();
    $statement->closeCursor();
    
    return $db->lastInsertId();
}

function update_bracket_map_list_isActive($bracket_id, $round, $isActive) {
    $db = Database::getDB();
    $query = 'UPDATE bracket_map_list
                     SET isActive = :isActive
                     WHERE bracket_id = :bracket_id AND round = :round';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_id', $bracket_id);
     $statement->bindValue(':round', $round);
    $statement->bindValue(':isActive', $isActive);
    $statement->execute();
    $statement->closeCursor();
}

function update_bracket_info($bracket_id, $bracket_name, $number_of_rounds) {
    $db = Database::getDB();
    $query = 'UPDATE bracket
                     SET bracket_name = :bracket_name, number_of_rounds = :number_of_rounds
                     WHERE id = :bracket_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':bracket_id', $bracket_id);
     $statement->bindValue(':bracket_name', $bracket_name);
    $statement->bindValue(':number_of_rounds', $number_of_rounds);
    $statement->execute();
    $statement->closeCursor();
}