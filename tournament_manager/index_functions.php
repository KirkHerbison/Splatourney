<?php

function getTournamnetData() {
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
        edit_tournament($tournament);
        require_once("tournament_edit.php");
    }
}
?>