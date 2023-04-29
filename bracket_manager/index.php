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
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $roundArray = array();

        $roundExists = true;
        $teamsData = [];
        $resultsData = [];

        $matches = get_matches_by_round_number(1, $tournament_id);

        //creates the teams list for the bracket
        foreach ($matches as $match) {
            if($match->getTeamOneId() != null){
                $teamOne = get_team_by_id($match->getTeamOneId());
            }else{
                $teamOne = new Team(null, null, null, null, null, null);
            }
            if($match->getTeamTwoId() != null){
                $teamTwo = get_team_by_id($match->getTeamTwoId());
            }
            else{
                $teamTwo = new Team(null, null, null, null, null, null);
            }
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

                    if($match->getTeamOneWins() == 0 && $match->getTeamTwoWins() == 0){
                        $roundData[] = [
                            null,
                            null
                        ];                        
                    }else{
                        $roundData[] = [
                            $match->getTeamOneWins(),
                            $match->getTeamTwoWins()
                        ];
                    }

                }
                $resultsData [] = $roundData;
            } else {
                $roundExists = false;
            }
        }

        // Combine teams and results into output array
        $dataForBracket = array(
            'teams' => $teamsData,
            'results' => $resultsData

        );

        // Convert output to JSON format
        $bracketData = json_encode($dataForBracket);
        require_once("bracket.php");
}

// Starts/creates the bracket for a tournament
else if ($controllerChoice == 'start_bracket') {
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    
    
    $match_number = 1;
    for ($round = 1; $round <= $bracket->getNumberOfRounds(); $round++) {
        $mapList = get_bracket_map_list_by_round_and_bracket_id($bracket->getId(), $round); 

        
        $totalGames =  get_map_count_by_map_list_id($mapList->getId());
        $wins_needed_to_win = 1;
        
        //gets the number of wins needed for a match to be done
        if($totalGames == 3){
           $wins_needed_to_win = 2;
        }else if($totalGames == 5){
            $wins_needed_to_win = 3;
        }else if($totalGames == 7){
            $wins_needed_to_win = 4;
        }else if($totalGames ==9){
            $wins_needed_to_win = 5;
        }else if($totalGames == 11){
            $wins_needed_to_win = 6;
        }
        
        $total_rounds = $bracket->getNumberOfRounds();
        $matches_in_round = pow(2, $total_rounds - $round);

        
        for ($i = 1; $i <= $matches_in_round; $i++) {
            insert_tournament_match($tournament_id, $bracket->getId(), $round, $wins_needed_to_win, $match_number);
            $match_number++;
        }   
    }
    
    
// Split teams into two groups
$num_teams = $bracket->getNumberOfRounds() * 2;
$half_num_teams = ceil($num_teams / 2);
$top_half = array_slice($teams, 0, $half_num_teams);
$bottom_half = array_slice($teams, $half_num_teams);

// Assign seeds to each group separately
$seeds = array();
for ($i = 1; $i <= $num_teams; $i++) {
    // Calculate the reversed binary representation of the seed
    $binary = strrev(str_pad(decbin($i), $total_rounds, '0', STR_PAD_LEFT));

    // Add the seed and binary representation to the array if it doesn't already exist
    if (!in_array($i, array_column($seeds, 'seed'))) {
        $seeds[] = array('seed' => $i, 'binary' => $binary);
    }
}

// Sort the seeds based on their reversed binary representations
usort($seeds, function($a, $b) {
    return strcmp($a['binary'], $b['binary']);
});


for ($i = 0; $i < $num_teams / 2; $i++) {
    $seedTop[] = $seeds[$i]['seed'];
    $seedBottom[] = $seeds[$num_teams - $i - 1]['seed'];
}
$seedBottom = array_reverse($seedBottom);

    $match_number = 1;
    for ($i = 0; $i < count($seedBottom); $i++) {
        update_match_seeding($match_number, $seedTop[$i], $seedBottom[$i], $bracket->getId());
        $match_number++;
    }
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




