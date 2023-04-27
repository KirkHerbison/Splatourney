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

    if ($tournament->getTournamentTypeId() == 1) {
        $roundExists = true;
        $teamsData = [];
        $resultsData = [];

        $matches = get_matches_by_round_number(1, $tournament_id);

        //creates the teams list for the bracket
        foreach ($matches as $match) {
            $teamOne = get_team_by_id($match->getTeamOneId());
            $teamTwo = get_team_by_id($match->getTeamTwoId());

            $teamsData[] = [
                $teamOne->getTeamName(),
                $teamTwo->getTeamName(),
            ];
        }

        //creates the results for the bracket
        for ($roundNumber = 1; $roundExists == true; $roundNumber++) {
            if (check_round_exists_by_number($roundNumber, $tournament_id)) {
                $matches = get_matches_by_round_number($roundNumber, $tournament_id);

                $roundData = [];

                foreach ($matches as $match) {
                    $teamOne = get_team_by_id($match->getTeamOneId());
                    $teamTwo = get_team_by_id($match->getTeamTwoId());

                    $roundData[] = [
                        $match->getTeamOneWins(),
                        $match->getTeamTwoWins()
                    ];
                }
                $resultsData [] = $roundData;
            } else {
                $roundExists = false;
            }
        }

        $extraTestData[] = [1, 2, 3, 4, 5, 6, 7];

        // Combine teams and results into output array
        $dataForBracket = array(
            'teams' => $teamsData,
            'results' => $resultsData,
            'extraData' => $extraTestData
        );

        // Convert output to JSON format
        $bracketData = json_encode($dataForBracket);
        require_once("bracket.php");
    }
}

// Starts/creates the bracket for a tournament
else if ($controllerChoice == 'start_bracket') {
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
       
    
    
    
    
    
    
    for ($round = 1; $x <= $bracket->getNumberOfRounds(); $round++) {
        $mapList = get_bracket_map_list_by_round_and_bracket_id($bracket->getId(), $round); 

        
        get_
        
        
        
        insert_tournament_match($tournament_id, $bracket->getId(), $round, wins_needed_to_win, match_number);
        
    }
    
    //creating empty matches
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    require_once("bracket.php");
    
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




