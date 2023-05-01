<?php
require_once('../model/database.php');
require_once('../model/bracket_db.php');

//var_dump($_POST);
//error_log(print_r($_POST, true));

$matchId = filter_input(INPUT_POST, 'matchId', FILTER_SANITIZE_NUMBER_INT);

if($matchId != null) {
    addTeamTwoWin($matchId);
    $match = get_match_by_id($matchId); 
    $bracket_id = $match->getBracketId();
    $tournament_id = $match->getTournamentId();
    $bracket = get_bracket_by_tournament_id($tournament_id);
  
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
    if($match->getTeamTwoWins() >= $wins_needed_to_win){
        $victory = 'true';
        
        
        //setting team One to the next game
        $current_round = $match->getRound();
        $current_match = $match->getMatchNumber();
        
        $number_of_rounds = $bracket->getNumberOfRounds();
        $total_matches_round_one = pow(2, $number_of_rounds - 1);
        
        //get total number of matches
        $total_matches = 0;
        $matches_in_round = $total_matches_round_one;
        for($i=1; $i <=$number_of_rounds; $i++){
            $total_matches += $matches_in_round;
            $matches_in_round /= 2;
        }
         
        //converts $current_match from the match number to the match position in the round
        for($i = 1; $i < $current_round; $i++){
            $current_match - $total_matches_round_one;
            $total_matches_round_one/2;          
        }
        
        //gets the position of the next match (round up to get the match)
        $next_position = $current_match/2.0;
        
        //getting the last match in the current round
        $end_of_round_match = $total_matches_round_one;       
        for($i = 1; $i < $current_round; $i++){
            $end_of_round_match = $end_of_round_match/2;
        }
        
        //gets the match to be updated
        $future_match = $end_of_round_match + ceil($next_position);
        
        
        
        //updates the team for next round
        if(fmod($next_position, 1) !== 0.0){
            update_match_team_one($future_match,$bracketMatch->getTeamTwoId(), $bracket_id);
            
        }
        else{
            update_match_team_two($future_match,$bracketMatch->getTeamTwoId(),$bracket_id);
        } 
    }
    
    
    
    
    
    
    
    
    
    
    
    echo  json_encode(['success' => true, 'score' => $match->getTeamTwoWins(),'victory' => $victory]);
}

?>



