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

// sends the user to the tournament registration page if register is selected in the header
if ($controllerChoice == 'tournament_register') {
    $tournamnetTypes = get_tournament_types();
    require_once("tournament_register.php");
}

// In the header when the user tournament list
else if ($controllerChoice == 'tournament_list'){   
    $tournaments = get_tournaments();
    require_once("tournament_list.php");
}


////////////////////////////////////////////////////////////////////////////////

// verifys information from the tournament register page and makes a decission bassed on results
else if ($controllerChoice == 'tournament_register_confirmation') {
    $tournamentOrganizerName = filter_input(INPUT_POST, 'tournamentOrganizerName');
    $tournamentType = filter_input(INPUT_POST, 'tournamentType');
    $tournamentName = filter_input(INPUT_POST, 'tournamentName');
    $tournamentAbout = filter_input(INPUT_POST, 'tournamentAbout');
    $tournamentPrizes = filter_input(INPUT_POST, 'tournamentPrizes');
    $tournamentContact = filter_input(INPUT_POST, 'tournamentContact');
    $tournamentRules = filter_input(INPUT_POST, 'tournamentRules');
    $tournamentDatetime = filter_input(INPUT_POST, 'tournamentDateTime');
    $tournamentDeadline = filter_input(INPUT_POST, 'tournamentDeadline');
    
    $today = new DateTime();
    
    $startDatetime = new DateTime(filter_input(INPUT_POST, 'tournamentDeadline'));
    $deadline = new DateTime(filter_input(INPUT_POST, 'tournamentDateTime'));
    
    $difference = $startDatetime->diff($deadline);
    $tournamnetTypes = get_tournament_types();
    
    if($tournamentOrganizerName == null || $tournamentOrganizerName == "" ){
        $error_message = "Tournament Organizer name reqired";
        require_once("tournament_register.php");
    }
    else if($tournamentName == null || $tournamentName == "" ){
        $error_message = "Tournament name reqired";
        require_once("tournament_register.php");
    }
    else if($tournamentDatetime == null){
        $error_message = "Tournament start date reqired";
        require_once("tournament_register.php");
    }
    else if($tournamentDeadline == null){
        $error_message = "Tournament Registration Deadline Reqired";
        require_once("tournament_register.php");
    }
    else if($today >= $startDatetime){
        $error_message = "The tournament can not be in the past";
        require_once("tournament_register.php");
    }
    else if($today >= $deadline){
        $error_message = "The registration deadline can not be in the past";
        require_once("tournament_register.php");
    }
    else if ($difference->invert == 1){
        $error_message = "Registration deadline must end before the tournaments start time";
        require_once("tournament_register.php");
    }
    else{
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDatetime);
        $sqlDatetime = $dt->format('Y-m-d H:i:s');
        $dl = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDeadline);
        $sqlDeadline = $dl->format('Y-m-d H:i:s');
       $tournament = new Tournament(
                null,
                $userLogedin->getID(),
                $tournamentOrganizerName,
                $tournamentType,
                null,
                $tournamentName,
               $sqlDatetime,
               $sqlDeadline,
               $tournamentAbout,
               $tournamentPrizes,
               $tournamentContact,
               $tournamentRules,
               1       
        );
       
        $id = add_tournament($tournament);
        $tournament->setId($id);
        require_once("tournament_edit.php");
    }
}

// Edits a tournament
else if ($controllerChoice == 'tournament_edit') {
    $id = filter_input(INPUT_POST, 'tournamentId');
    $tournamentOrganizerName = filter_input(INPUT_POST, 'tournamentOrganizerName');
    $tournamentType = filter_input(INPUT_POST, 'tournamentType');
    $tournamentName = filter_input(INPUT_POST, 'tournamentName');
    $tournamentAbout = filter_input(INPUT_POST, 'tournamentAbout');
    $tournamentPrizes = filter_input(INPUT_POST, 'tournamentPrizes');
    $tournamentContact = filter_input(INPUT_POST, 'tournamentContact');
    $tournamentRules = filter_input(INPUT_POST, 'tournamentRules');
    $tournamentDatetime = filter_input(INPUT_POST, 'tournamentDateTime');
    $tournamentDeadline = filter_input(INPUT_POST, 'tournamentDeadline');
    
    $today = new DateTime();
    
    $startDatetime = new DateTime(filter_input(INPUT_POST, 'tournamentDeadline'));
    $deadline = new DateTime(filter_input(INPUT_POST, 'tournamentDateTime'));
    
    $difference = $startDatetime->diff($deadline);
    $tournamnetTypes = get_tournament_types();
    $tournament = get_tournament_by_id($id);
    
    if($tournamentOrganizerName == null || $tournamentOrganizerName == "" ){
        $error_message = "Tournament Organizer name reqired";
        require_once("tournament_edit.php");
    }
    else if($tournamentName == null || $tournamentName == "" ){
        $error_message = "Tournament name reqired";
        require_once("tournament_edit.php");
    }
    else if($tournamentDatetime == null){
        $error_message = "Tournament start date reqired";
        require_once("tournament_edit.php");
    }
    else if($tournamentDeadline == null){
        $error_message = "Tournament Registration Deadline Reqired";
        require_once("tournament_edit.php");
    }
    else if($today >= $startDatetime){
        $error_message = "The tournament can not be in the past";
        require_once("tournament_edit.php");
    }
    else if($today >= $deadline){
        $error_message = "The registration deadline can not be in the past";
        require_once("tournament_edit.php");
    }
    else if ($difference->invert == 1){
        $error_message = "Registration deadline must end before the tournaments start time";
        require_once("tournament_edit.php");
    }
    else{
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDatetime);
        $sqlDatetime = $dt->format('Y-m-d H:i:s');
        $dl = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDeadline);
        $sqlDeadline = $dl->format('Y-m-d H:i:s');
        $tournament = new Tournament(
                $id,
                $userLogedin->getID(),
                $tournamentOrganizerName,
                $tournamentType,
                null,
                $tournamentName,
               $sqlDatetime,
               $sqlDeadline,
               $tournamentAbout,
               $tournamentPrizes,
               $tournamentContact,
               $tournamentRules,
               1       
        );
       $error_message = "Tournament Edit Saved!";
        add_tournament($tournament);
        require_once("tournament_edit.php");
    }
}


////////////////////////////////////////////////////////////////////////////////

// sends user to the tournament bracket when selected from tournament_list
else if ($controllerChoice == 'tournament_bracket'){
    
    $tournament_id = filter_input(INPUT_POST, 'tournamentId');
    $tournament = get_tournament_by_id($tournament_id);
    $roundArray = array();
            
    if($tournament->getTournamentTypeId() == 1){
        $roundExists = true;
     
        for($roundNumber = 1; $roundExists == true; $roundNumber++){
            if(check_round_exists_by_number($roundNumber, $tournament_id)){
                $matches = get_matches_by_round_number($roundNumber, $tournament_id);       
                $round = new Round($roundNumber, $matches);              
                $roundArray[] = $round;
            }else{
                $roundExists = false;
            }
        }
        require_once("tournament_bracket.php");
    }        
            
            
}


////////////////////////////////////////////////////////////////////////////////

// Final else very helpful for debugging.
else {
    // Show this is an unhandled $controllerChoice
    // Show generic else page
    require_once '../view/header.php';
    echo "<h1>Not yet implimented... </h1>";
    echo "<h2> controllerChoice:  $controllerChoice</h2>";
    echo "<h3> File:  team_manager/index.php </h3>";
    require_once '../view/footer.php';
}

?>




