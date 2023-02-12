<?php
require_once '../model/User.php';
require_once '../model/Team.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/team_db.php');
require_once('../model/tournament_db.php');

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

// sends the user to the tournament registration page if register is selected in the header
if ($controllerChoice == 'tournament_register') {
    $tournamnetTypes = get_tournament_types();
    require_once("tournament_register.php");
}

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
    

    
    if($tournamentOrganizerName == null || $tournamentOrganizerName == "" ){
        $error_message = "Tournament Organizer name reqired";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else if($tournamentName == null || $tournamentName == "" ){
        $error_message = "Tournament name reqired";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else if($tournamentDatetime == null){
        $error_message = "Tournament start date reqired";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else if($tournamentDeadline == null){
        $error_message = "Tournament Registration Deadline Reqired";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else if($today >= $startDatetime){
        $error_message = "The tournament can not be in the past";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else if($today >= $deadline){
        $error_message = "The registration deadline can not be in the past";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else if ($difference->invert == 1){
        $error_message = "Registration deadline must end before the tournaments start time";
        $tournamnetTypes = get_tournament_types();
        require_once("tournament_register.php");
    }
    else{
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDatetime);
        $sqlDatetime = $dt->format('Y-m-d H:i:s');
        $dl = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDeadline);
        $sqlDeadline = $dl->format('Y-m-d H:i:s');
        
        
        
       $tournamentToCreate = new Tournament(
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
       
        add_tournament($tournamentToCreate);
        require_once("tournament_register_confirmation.php");
    }
}

