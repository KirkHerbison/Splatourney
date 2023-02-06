<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Customer
 *
 * @author Kirk Herbison
 */
class User {

    private $id, $user_type_id, $email_address, $username, $password, $first_name, $last_name, $switch_friend_code, $switch_username, $splashtag, $discord_username, $discord_client_secret, $isActive, $display_name;

    public function __construct($id, $user_type_id, $email_address, $username, $password, $first_name, $last_name, $switch_friend_code, $switch_username, $splashtag, $discord_username, $discord_client_secret, $isActive, $display_name) {
        $this->id = $id;
        $this->user_type_id = $user_type_id;
        $this->email_address = $email_address;
        $this->username = $username;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->switch_friend_code = $switch_friend_code;
        $this->switch_username = $switch_username;
        $this->splashtag = $splashtag;
        $this->discord_username = $discord_username;
        $this->discord_client_secret = $discord_client_secret;
        $this->isActive = $isActive;
        $this->display_name = $display_name;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserTypeId() {
        return $this->user_type_id;
    }

    public function getEmailAddress() {
        return $this->email_address;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getSwitchFriendCode() {
        return $this->switch_friend_code;
    }

    public function getSwitchUsername() {
        return $this->switch_username;
    }

    public function getSplashtag() {
        return $this->splashtag;
    }

    public function getDiscordUsername() {
        return $this->discord_username;
    }

    public function getDiscordClientSecret() {
        return $this->discord_client_secret;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getDisplayName() {
        return $this->display_name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUserTypeId($userTypeId) {
        $this->user_type_id = $userTypeId;
    }

    public function setEmailAddress($emailAddress) {
        $this->email_address = $emailAddress;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setFirstName($firstName) {
        $this->first_name = $firstName;
    }

    public function setLastName($lastName) {
        $this->last_name = $lastName;
    }

    public function setSwitchFriendCode($switchFriendCode) {
        $this->switch_friend_code = $switchFriendCode;
    }

    public function setSwitchUsername($switchUsername) {
        $this->switch_username = $switchUsername;
    }

    public function setSplashtag($splashtag) {
        $this->splashtag = $splashtag;
    }

    public function setDiscordUsername($discordUsername) {
        $this->discord_username = $discordUsername;
    }

    public function setDiscordClientSecret($discordClientSecret) {
        $this->discord_client_secret = $discordClientSecret;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    public function setDisplayName($displayName) {
        $this->display_name = $displayName;
    }

}
