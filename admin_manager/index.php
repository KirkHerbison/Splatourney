<?php

require_once '../model/User.php';
require_once '../model/Team.php';
require_once '../model/Tournament.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/team_db.php');
require_once('../model/tournament_db.php');
require_once('../model/bracket_db.php');
require_once('../model/Round.php');
require_once('../model/BracketMatch.php');
session_start();

////////////////////////////////////////////////////////////////////////////////
//gets user for session for use or creates an empty user object so the code does not break
if (isset($_SESSION['userLogedin'])) {
    $userLogedin = $_SESSION['userLogedin'];
} else {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

////////////////////////////////////////////////////////////////////////////////
// Get the data from either the GET or POST collection.
$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
$error_message = '';
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

////////////////////////////////////////////////////////////////////////////////
// sends the user to the bracket type page
if ($controllerChoice == 'admin') {
    $users = get_users();
    require_once("admin.php");
 
}

// Sends user to a match when the match is selected
else if ($controllerChoice == 'match') {
    $matchId = $_GET['matchId'];
$tournamentId = $_GET['tournamentId'];
    

    $bracketMatch = get_match_by_id(filter_input(INPUT_GET, 'matchId', FILTER_SANITIZE_NUMBER_INT));
    $chat = get_chat_by_match_id(filter_input(INPUT_GET, 'matchId', FILTER_SANITIZE_NUMBER_INT));
    $messages = get_messages_by_chat_id($chat->getId());
    $games = get_match_games_by_id($bracketMatch->getBracketId());
    $tournament = get_tournament_by_id(filter_input(INPUT_GET, 'tournamentId', FILTER_SANITIZE_NUMBER_INT));

    require_once("match.php");
    
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
// Final else very helpful for debugging.x
else {
    // Show this is an unhandled $controllerChoice
    // Show generic else page
    require_once '../view/header.php';
    echo "<h1>Not yet implimented... </h1>";
    echo "<h2> controllerChoice:  $controllerChoice</h2>";
    echo "<h3> File:  team_manager/index.php </h3>";
    require_once '../view/footer.php';
}




