<?php
require_once('../model/database.php');
require_once('../model/bracket_db.php');

//var_dump($_POST);
//error_log(print_r($_POST, true));

$matchId = filter_input(INPUT_POST, 'matchId', FILTER_SANITIZE_NUMBER_INT);

if($matchId != null) {
    addTeamOneWin($matchId);
    $match = get_match_by_id($matchId);
    $bracket_id = $match->getBracketId();
    $tournament_id = $match->getTournamentId();
  
    $bracketMatch = get_math_by_match_number_and_touranemnt_id($match->getMatchNumber(),$tournament_id);
    
    
    $bracket_match_list = get_bracket_map_list_by_round_and_bracket_id($bracket_id, $bracketMatch->getRound());
  
  
  
  
    $totalGames =  get_map_count_by_map_list_id($bracket_match_list->getId());
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
  
    $victory = 'false';
    if($match->getTeamOneWins() >= $wins_needed_to_win){
        $victory = 'true';
    }

    echo  json_encode(['success' => true, 'score' => $match->getTeamOneWins(),'victory' => $victory ]);
}

?>



