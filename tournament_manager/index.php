<?php
require_once '../model/User.php';
require_once '../model/Team.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/team_db.php');

session_start();

//gets user for session for use or creates an empty user object so the code does not break
if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

$error_message = '';

// Get the data from either the GET or POST collection.
$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

