<?php
require_once('../model/database.php');
require_once('../model/bracket_db.php');

//var_dump($_POST);
//error_log(print_r($_POST, true));

$matchId = filter_input(INPUT_POST, 'matchId', FILTER_SANITIZE_NUMBER_INT);

if($matchId != null) {
  $updatedWins = addTeamOneWin($matchId);
  
  echo $updatedWins;
}

?>



