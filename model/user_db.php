<?php

require_once('../model/User.php');

function get_users() {
    $db = Database::getDB();
    $userArray = array();

    $query = 'SELECT * FROM splatourney_user' ;
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($users as $user) {
        $userObject = new User($user['ID'],
                $user['user_type_id'],
                $user['email_address'],
                $user['username'],
                $user['password'],
                $user['first_name'],
                $user['last_name'],
                $user['switch_friend_code'],
                $user['switch_username'],
                $user['splashtag'],
                $user['discord_username'],
                $user['discord_client_secret'],
                $user['isActive'],
                $user['display_name']);
        $userArray[] = $userObject;
    }
    return $userArray;
}

function search_users($username) {
    $db = Database::getDB();
    $userArray = array();

    $query = 'SELECT * FROM splatourney_user
                WHERE username LIKE "%":username"%"';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($users as $user) {
        $userObject =  new User($user['ID'],
                $user['user_type_id'],
                $user['email_address'],
                $user['username'],
                $user['password'],
                $user['first_name'],
                $user['last_name'],
                $user['switch_friend_code'],
                $user['switch_username'],
                $user['splashtag'],
                $user['discord_username'],
                $user['discord_client_secret'],
                $user['isActive'],
                $user['display_name']);
        $userArray[] = $userObject;
    }
    return $userArray;
}

function get_user_by_email_password($email, $password) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                WHERE email_address = :email_address AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':email_address', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    if ($user != null) {
        $userObject = new User($user['ID'],
                $user['user_type_id'],
                $user['email_address'],
                $user['username'],
                $user['password'],
                $user['first_name'],
                $user['last_name'],
                $user['switch_friend_code'],
                $user['switch_username'],
                $user['splashtag'],
                $user['discord_username'],
                $user['discord_client_secret'],
                $user['isActive'],
                $user['display_name']);
        return $userObject;
    } else {
        return null;
    }
}

function get_user_by_id($ID) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $ID);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    $userObject = new User($user['ID'],
                $user['user_type_id'],
                $user['email_address'],
                $user['username'],
                $user['password'],
                $user['first_name'],
                $user['last_name'],
                $user['switch_friend_code'],
                $user['switch_username'],
                $user['splashtag'],
                $user['discord_username'],
                $user['discord_client_secret'],
                $user['isActive'],
                $user['display_name']);
    return $userObject;
}

function get_user_by_username($username) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    $userObject = new User($user['ID'],
                $user['user_type_id'],
                $user['email_address'],
                $user['username'],
                $user['password'],
                $user['first_name'],
                $user['last_name'],
                $user['switch_friend_code'],
                $user['switch_username'],
                $user['splashtag'],
                $user['discord_username'],
                $user['discord_client_secret'],
                $user['isActive'],
                $user['display_name']);
    return $userObject;
}

function check_user_email($email_address) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                      WHERE email_address = :email_address';
    $statement = $db->prepare($query);
    $statement->bindValue(':email_address', $email_address);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return $user;
}

function check_user_discord_client_secret($discord_client_secret) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                      WHERE discord_client_secret = :discord_client_secret';
    $statement = $db->prepare($query);
    $statement->bindValue(':discord_client_secret', $discord_client_secret);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return $user;
}

function check_discord_username($discord_username) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                      WHERE discord_username = :discord_username';
    $statement = $db->prepare($query);
    $statement->bindValue(':discord_username', $discord_username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return $user;
}


function check_splashtag($splashtag) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                      WHERE splashtag = :splashtag';
    $statement = $db->prepare($query);
    $statement->bindValue(':splashtag', $splashtag);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return $user;
}

function check_switch_friend_code($switch_friend_code) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                      WHERE switch_friend_code = :switch_friend_code';
    $statement = $db->prepare($query);
    $statement->bindValue(':switch_friend_code', $switch_friend_code);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return $user;
}

function check_username($username) {
    $db = Database::getDB();
    $query = 'SELECT * FROM splatourney_user
                      WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    return $user;
}

function add_user($user) {
    $db = Database::getDB();
    $query = 'INSERT INTO splatourney_user (user_type_id, email_address, username, password, first_name, last_name, switch_friend_code, switch_username, splashtag, discord_username, discord_client_secret, display_name)
                     VALUES(:user_type_id, :email_address, :username, :password, :first_name, :last_name, :switch_friend_code, :switch_username, :splashtag, :discord_username, :discord_client_secret, :display_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_type_id', $user->getUserTypeId());
    $statement->bindValue(':email_address', $user->getEmailAddress());
    $statement->bindValue(':username', $user->getUsername());
    $statement->bindValue(':password', $user->getPassword());
    $statement->bindValue(':first_name', $user->getFirstName());
    $statement->bindValue(':last_name', $user->getLastName());
    $statement->bindValue(':switch_friend_code', $user->getSwitchFriendCode());
    $statement->bindValue(':switch_username', $user->getSwitchUsername());
    $statement->bindValue(':splashtag', $user->getSplashtag());
    $statement->bindValue(':discord_username', $user->getDiscordUsername());
    $statement->bindValue(':discord_client_secret', $user->getDiscordClientSecret());
    $statement->bindValue(':display_name', $user->getDisplayName());
    $statement->execute();
    $statement->closeCursor();
}

function update_user($user) {
    $db = Database::getDB();
    $query = 'UPDATE wluser
                     SET wlUserRoleID = :wlUserRoleID, firstName = :firstName,lastName = :lastName,email = :email,password = :password,
                     address = :address, city = :city,st = :state,zip = :zip, phone = :phone, isActive = :isActive
                     WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $user->getId());
    $statement->bindValue(':wlUserRoleID', $user->getRoleId());
    $statement->bindValue(':firstName', $user->getFirstName());
    $statement->bindValue(':lastName', $user->getLastName());
    $statement->bindValue(':email', $user->getEmail());
    $statement->bindValue(':password', $user->getPassword());
    $statement->bindValue(':address', $user->getAddress());
    $statement->bindValue(':city', $user->getCity());
    $statement->bindValue(':state', $user->getState());
    $statement->bindValue(':zip', $user->getZip());
    $statement->bindValue(':phone', $user->getPhone());
    $statement->bindValue(':isActive', $user->getIsActive());
    $statement->execute();
    $statement->closeCursor();
}

?>