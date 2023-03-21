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
session_start();

//allows the page to reload if the back button of the browser is clicked
header("Cache-Control: no cache");

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
if ($controllerChoice == 'bracket') {
    
    
    $tournament_id = filter_input(INPUT_POST, 'tournamentId');
    $tournament = get_tournament_by_id($tournament_id);
    $roundArray = array();

    //single elimination
    if ($tournament->getTournamentTypeId() == 1) {
        $roundExists = true;

        for ($roundNumber = 1; $roundExists == true; $roundNumber++) {
            if (check_round_exists_by_number($roundNumber, $tournament_id)) {
                $matches = get_matches_by_round_number($roundNumber, $tournament_id);
                $round = new Round($roundNumber, $matches);
                $roundArray[] = $round;
            } else {
                $roundExists = false;
            }
        }
        require_once("single_elimination_bracket.php");
    }
}

// Sends user to a match when the match is selected
else if ($controllerChoice == 'match') {
    $match = get_matche_by_id(filter_input(INPUT_POST, 'matchId'));
    $tournament = get_tournament_by_id(filter_input(INPUT_POST, 'tournamentId'));
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




