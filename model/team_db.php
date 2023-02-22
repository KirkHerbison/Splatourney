<?php

require_once('../model/User.php');
require_once('../model/Team.php');

function add_team($team) {
    $db = Database::getDB();
    $query = 'INSERT INTO team (captain_user_id, team_name, team_image_link)
                VALUES(:captain_user_id, :team_name, :team_image_link)';
    $statement = $db->prepare($query);
    $statement->bindValue(':captain_user_id', $team->getCaptainUserId());
    $statement->bindValue(':team_name', $team->getTeamName());
    $statement->bindValue(':team_image_link', $team->getTeamImageLink());
    $statement->execute();
    $statement->closeCursor();
    
    return $db->lastInsertId();
}

function get_teams(){
    $db = Database::getDB();
    $teamArray = array();
    $query = 'SELECT * FROM team t
              JOIN splatourney_user u ON u.ID = t.captain_user_id';
    $statement = $db->prepare($query);
    $statement->execute();
    $teams = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($teams as $team) {
        $teamObject = new Team($team['ID'],
                $team['captain_user_id'],
                $team['username'],
                $team['team_name'],
                $team['team_image_link'],
                $team['isActive']);
        $teamArray[] = $teamObject;
    }
    return $teamArray;
}

function search_teams($name) {
    $db = Database::getDB();
    $teamArray = array();
    $query = 'SELECT * FROM team t
                JOIN splatourney_user u ON u.ID = t.captain_user_id
                WHERE team_name LIKE "%":team_name"%"';
    $statement = $db->prepare($query);
    $statement->bindValue(':team_name', $name);
    $statement->execute();
    $teams = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($teams as $team) {
        $teamObject = new Team($team['ID'],
                $team['captain_user_id'],
                $team['username'],
                $team['team_name'],
                $team['team_image_link'],
                $team['isActive']);
        $teamArray[] = $teamObject;
    }
    return $teamArray;
}

function get_team_by_id($id){
    $db = Database::getDB();
    $query = 'SELECT * FROM team t
                JOIN splatourney_user u ON u.ID = t.captain_user_id
                WHERE t.id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $selectedTeam = $statement->fetch();
    $statement->closeCursor();
        $team = new Team($selectedTeam['ID'],
                $selectedTeam['captain_user_id'],
                $selectedTeam['username'],
                
                $selectedTeam['team_name'],
                $selectedTeam['team_image_link'],
                $selectedTeam['isActive']);
    return $team;
}

function get_teams_by_user_id($id){
    $db = Database::getDB();
    $teamArray = array();

    $query = 'SELECT * FROM team t
                JOIN splatourney_user u ON u.ID = t.captain_user_id
                WHERE captain_user_id = :captain_user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':captain_user_id', $id);
    $statement->execute();
    $teams = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($teams as $team) {
        $teamObject = new Team($team['ID'],
                $team['captain_user_id'],
                $team['team_name'],
                $team['username'],
                $team['team_image_link'],
                $team['isActive']);
        $teamArray[] = $teamObject;
    }
    return $teamArray;
}




function check_if_member_exists($user,$team) {
    $db = Database::getDB();
    $query = 'SELECT * FROM team_member_list
                WHERE user_id = :user_id AND isActive = 1 AND team_id = :team_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user->getId());
    $statement->bindValue(':team_id', $team->getId());
    $statement->execute();
    $userExists = $statement->fetch();
    $statement->closeCursor();

    return $userExists;
}

function check_if_member_is_not_active($user, $team) {
    $db = Database::getDB();
    $query = 'SELECT * FROM team_member_list
                WHERE user_id = :user_id AND isActive = 0 AND team_id = :team_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user->getId());
    $statement->bindValue(':team_id', $team->getId());
    $statement->execute();
    $userExists = $statement->fetch();
    $statement->closeCursor();

    return $userExists;
}

function update_team_member_isActive($user, $team){
    $db = Database::getDB();
    $query = 'UPDATE team_member_list
                     SET isActive = 1
                     WHERE user_id = :user_id AND team_id = :team_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user->getId());
    $statement->bindValue(':team_id', $team->getId());
    $statement->execute();
    $statement->closeCursor();
}

function remove_team_member($user, $team){
    $db = Database::getDB();
    $query = 'UPDATE team_member_list
                     SET isActive = 0
                     WHERE user_id = :user_id AND team_id = :team_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user->getId());
    $statement->bindValue(':team_id', $team->getId());
    $statement->execute();
    $statement->closeCursor();
}

function remove_team($id){
    $db = Database::getDB();
    $query = 'UPDATE team
                     SET isActive = 0
                     WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue('id', $id);
    $statement->execute();
    $statement->closeCursor();
}

function activate_team($id){
    $db = Database::getDB();
    $query = 'UPDATE team
                     SET isActive = 1
                     WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue('id', $id);
    $statement->execute();
    $statement->closeCursor();
}




function check_if_team_exists($team) {
    $db = Database::getDB();
    $query = 'SELECT * FROM team
                WHERE captain_user_id = :captain_user_id AND team_name = :team_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':captain_user_id', $team->getCaptainUserId());
    $statement->bindValue(':team_name', $team->getTeamName());
    $statement->execute();
    $teamExists = $statement->fetch();
    $statement->closeCursor();

    return $teamExists;
}

function add_team_member($user, $team){
    $db = Database::getDB();
    $query = 'INSERT INTO team_member_list (user_id, team_id)
                VALUES(:user_id, :team_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user->getId());
    $statement->bindValue(':team_id', $team->getId());
    $statement->execute();
    $statement->closeCursor();
    
}

function get_team_members($team) {
    $db = Database::getDB();
    $userArray = array();

    $query = 'SELECT * FROM splatourney_user u
                JOIN team_member_list ml ON u.ID = ml.user_id
                WHERE ml.team_id = :team_id AND u.isActive = 1 AND ml.isActive = 1';
    $statement = $db->prepare($query);
    $statement->bindValue(':team_id', $team->getId());
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($users as $user) {
        $userObject = new User($user['user_id'],
                null,
                null,
                $user['username'],
                null,
                null,
                null,
                $user['switch_friend_code'],
                $user['switch_username'],
                $user['splashtag'],
                $user['discord_username'],
                null,
                null,
                null);
        $userArray[] = $userObject;
    }
    return $userArray;
}
