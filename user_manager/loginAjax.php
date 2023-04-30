<?php

require_once '../model/User.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
session_start();

$email = filter_input(INPUT_POST, 'email');
$pass = filter_input(INPUT_POST, 'pass');

$user = validate_login($email, $pass);
$ID = -1;
if ($user != null) {
    $ID = $user->getId();
}
if ($ID > 0) {
    $_SESSION['userLogedin'] = $user;
    $userLogedin = $_SESSION['userLogedin'];
    echo json_encode(['success' => true]);
}

