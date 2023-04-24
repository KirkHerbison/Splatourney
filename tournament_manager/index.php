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
require_once('../model/Bracket.php');
require_once('../model/MapList.php');
require_once('../model/Map.php');
require_once('../model/Mode.php');
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
$error_message_bracket = '';
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

////////////////////////////////////////////////////////////////////////////////
// sends the user to the tournament registration page if register is selected in the header
if ($controllerChoice == 'tournament_register') {
    require_once("tournament_register.php");
}

// In the header when the user tournament list
else if ($controllerChoice == 'tournament_list') {
    $tournaments = get_tournaments();
    require_once("tournament_list.php");
}

// The tournmanet list search by tournaments
else if ($controllerChoice == 'tournament_search_by_name') {
    $tournaments = search_tournaments(filter_input(INPUT_POST, 'tournament_search'));
    require_once("tournament_list.php");
}

// To a users tournament to edit
else if ($controllerChoice == 'edit_my_tournament') {
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    require_once("tournament_edit.php");
}

// In the header when the user selects my teams
else if ($controllerChoice == 'my_tournament_list') {
    if($userLogedin->getId() >0){
        $tournamentsOwned = get_tournaments_by_ownerId($userLogedin->getId());
        require_once("user_tournament_list.php");
    }
    else{
        require_once('../user_manager/user_login.php');
    }
}


////////////////////////////////////////////////////////////////////////////////
else if ($controllerChoice == 'map_list') {
    $maps = get_maps();
    require_once('map_list.php');
}

////////////////////////////////////////////////////////////////////////////////
// verifys information from the tournament register page and makes a decission bassed on results
else if ($controllerChoice == 'tournament_register_confirmation') {
    $tournamentOrganizerName = filter_input(INPUT_POST, 'tournamentOrganizerName');
    $tournamentName = filter_input(INPUT_POST, 'tournamentName');
    $tournamentAbout = filter_input(INPUT_POST, 'tournamentAbout');
    $tournamentPrizes = filter_input(INPUT_POST, 'tournamentPrizes');
    $tournamentContact = filter_input(INPUT_POST, 'tournamentContact');
    $tournamentRules = filter_input(INPUT_POST, 'tournamentRules');
    $tournamentDatetime = filter_input(INPUT_POST, 'tournamentDateTime');
    $tournamentDeadline = filter_input(INPUT_POST, 'tournamentDeadline');
    $imageValid = true;
    $today = new DateTime();

    $startDatetime = new DateTime(filter_input(INPUT_POST, 'tournamentDeadline'));
    $deadline = new DateTime(filter_input(INPUT_POST, 'tournamentDateTime'));

    $difference = $startDatetime->diff($deadline);
    $tournamnetTypes = get_tournament_types();

    if ($tournamentOrganizerName == null || $tournamentOrganizerName == "") {
        $error_message = "Tournament Organizer name reqired";
        require_once("tournament_register.php");
    } else if ($tournamentName == null || $tournamentName == "") {
        $error_message = "Tournament name reqired";
        require_once("tournament_register.php");
    } else if ($tournamentDatetime == null) {
        $error_message = "Tournament start date reqired";
        require_once("tournament_register.php");
    } else if ($tournamentDeadline == null) {
        $error_message = "Tournament Registration Deadline Reqired";
        require_once("tournament_register.php");
    } else if ($today >= $startDatetime) {
        $error_message = "The tournament can not be in the past";
        require_once("tournament_register.php");
    } else if ($today >= $deadline) {
        $error_message = "The registration deadline can not be in the past";
        require_once("tournament_register.php");
    } else if ($difference->invert == 1) {
        $error_message = "Registration deadline must end before the tournaments start time";
        require_once("tournament_register.php");
    } else {
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDatetime);
        $sqlDatetime = $dt->format('Y-m-d H:i:s');
        $dl = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDeadline);
        $sqlDeadline = $dl->format('Y-m-d H:i:s');
        $tournament = new Tournament(
                null,
                $userLogedin->getID(),
                $tournamentOrganizerName,
                1,
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

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) { // start for image upload
            $target_dir = "../images/tournament_images/"; // this is the initial file path to my images folder
            //this creates a unique identity for the image, something like teamImage_1236781236.php
            //uniqueid() gets a random number bassed on current time
            //.path info gets the file type (.jpg, .jpeg, .png [or invalid files])
            $image_name = 'teamImage_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $target_file = $target_dir . $image_name; // this combines the ../images/ with the image name on the end
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // gets file type for validation


            if (in_array($imageFileType, array('jpg', 'jpeg', 'png'))) { // verifys the file type is valid
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) { //attempts to put file into folder
                    $tournament->setTournamentBannerLink($image_name); //database call to put link into database
                } else { //file upload did not work
                    $imageValid = false;
                    $error_message = "Sorry, there was an error uploading your file.";
                }
            } else { // file type was invalid
                $imageValid = false;
                $error_message = "Sorry, only JPG, JPEG, & PNG files are allowed.";
            }
        } //end for image upload

        if ($imageValid == true) {
            $id = add_tournament($tournament);
            insert_bracket_by_tournament_id($id);
            $bracket = get_bracket_by_tournament_id($id);
            $bracket_id = $bracket->getId();
            
            // Loop through rounds 1 to 11
            for ($round = 1; $round <= 11; $round++) {
                // Set isActive based on round number
                    $isActive = ($round === 1) ? 1 : 0;   
                // Insert bracket map list for this round
                $map_list_id = insert_bracket_map_list_by_round_and_bracket_id($bracket_id, $round, $isActive);                          
                // Loop through games 1 to 11 for this map list
                for ($game_number = 1; $game_number <= 11; $game_number++) {
                    // Set isActive based on game number
                    $isActive = ($game_number === 1) ? 1 : 0;             
                    // Insert map list map for this game number
                    insert_map_list_map_by_map_list_id_and_game_number($map_list_id, $game_number, $isActive);
                }
            }
            $tournament->setId($id);
            $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
            $maps = get_maps();
            $modes = get_modes();
            require_once("tournament_edit.php");
        }
        else{
            require_once("tournament_register.php");
        }
    }
}

// Updates a tournament
else if ($controllerChoice == 'tournament_update_confirmation') {
    $tournamentOrganizerName = filter_input(INPUT_POST, 'tournamentOrganizerName');
    $tournamentName = filter_input(INPUT_POST, 'tournamentName');
    $tournamentAbout = filter_input(INPUT_POST, 'tournamentAbout');
    $tournamentPrizes = filter_input(INPUT_POST, 'tournamentPrizes');
    $tournamentContact = filter_input(INPUT_POST, 'tournamentContact');
    $tournamentRules = filter_input(INPUT_POST, 'tournamentRules');
    $tournamentDatetime = filter_input(INPUT_POST, 'tournamentDateTime');
    $tournamentDeadline = filter_input(INPUT_POST, 'tournamentDeadline');
    $imageValid = true;
    $today = new DateTime();
    $startDatetime = new DateTime(filter_input(INPUT_POST, 'tournamentDeadline'));
    $deadline = new DateTime(filter_input(INPUT_POST, 'tournamentDateTime'));
    $difference = $startDatetime->diff($deadline);
    $tournamnetTypes = get_tournament_types();
    $tournamentId = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournamentId);
    
    

    if ($tournamentOrganizerName == null || $tournamentOrganizerName == "") {
        $error_message = "Tournament Organizer name reqired";
        require_once("tournament_edit.php");
    } else if ($tournamentName == null || $tournamentName == "") {
        $error_message = "Tournament name reqired";
        require_once("tournament_edit.php");
    } else if ($tournamentDatetime == null) {
        $error_message = "Tournament start date reqired";
        require_once("tournament_edit.php");
    } else if ($tournamentDeadline == null) {
        $error_message = "Tournament Registration Deadline Reqired";
        require_once("tournament_edit.php");
    } else if ($today >= $startDatetime) {
        $error_message = "The tournament can not be in the past";
        require_once("tournament_edit.php");
    } else if ($today >= $deadline) {
        $error_message = "The registration deadline can not be in the past";
        require_once("tournament_edit.php");
    } else if ($difference->invert == 1) {
        $error_message = "Registration deadline must end before the tournaments start time";
        require_once("tournament_edit.php");
    } else {
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDatetime);
        $sqlDatetime = $dt->format('Y-m-d H:i:s');
        $dl = DateTime::createFromFormat('Y-m-d\TH:i', $tournamentDeadline);
        $sqlDeadline = $dl->format('Y-m-d H:i:s');
        $tournamentUpdated = new Tournament(
                $tournament->getId(),
                $tournament->getTournamentOwnerId(),
                $tournamentOrganizerName,
                1,
                $tournament->getTournamentBannerLink(),
                $tournamentName,
                $sqlDatetime,
                $sqlDeadline,
                $tournamentAbout,
                $tournamentPrizes,
                $tournamentContact,
                $tournamentRules,
                1
        );

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) { // start for image upload
            $target_dir = "../images/tournament_images/"; // this is the initial file path to my images folder
            //this creates a unique identity for the image, something like teamImage_1236781236.php
            //uniqueid() gets a random number bassed on current time
            //.path info gets the file type (.jpg, .jpeg, .png [or invalid files])
            $image_name = 'teamImage_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $target_file = $target_dir . $image_name; // this combines the ../images/ with the image name on the end
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // gets file type for validation


            if (in_array($imageFileType, array('jpg', 'jpeg', 'png'))) { // verifys the file type is valid
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) { //attempts to put file into folder
                    $tournamentUpdated->setTournamentBannerLink($image_name); //database call to put link into database
                } else { //file upload did not work
                    $imageValid = false;
                    $error_message = "Sorry, there was an error uploading your file.";
                }
            } else { // file type was invalid
                $imageValid = false;
                $error_message = "Sorry, only JPG, JPEG, & PNG files are allowed.";
            }
        } //end for image upload

        if ($imageValid == true) {
            update_tournament($tournamentUpdated);
            $bracket = get_bracket_by_tournament_id($tournamentId);
            $tournament = get_tournament_by_id($tournamentId);
            $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
            $maps = get_maps();
            $modes = get_modes();
            require_once("tournament_edit.php");
        }
        else{
            require_once("tournament_edit.php");
        }
    }
} 

else if ($controllerChoice == 'insert_bracket') {

    $bracket = new Bracket(
            0,
            filter_input(INPUT_POST, 'tournamentId'),
            filter_input(INPUT_POST, 'tournamentTypeId'),
            filter_input(INPUT_POST, 'tournamentBracketName')
    );

    //this is just a test for commit/pushs


    $bracket->setId(insert_bracket($bracket));

    $maxMatches = pow(2, (int) filter_input(INPUT_POST, 'rounds'));
    $maxRounds = log($maxMatches, 2);
    $round = (int) filter_input(INPUT_POST, 'rounds');
    $roundCurrent = $round;
    $matchNumber = 1;

    //inserts each match with it's round #. will always insert like 1,1,1,1,2,2,3
    while ($matchNumber <= $maxMatches) {
        for ($i = 0; $i < pow(2, $round - 1); $i++) {
            if ($round > 0) {
                insert_match($bracket, $round);
            }
            $matchNumber++;
            if ($matchNumber > $maxMatches) {
                break;
            }
        }
        $round--;
    }

    $tournament = get_tournament_by_id(filter_input(INPUT_POST, 'tournamentId'));
    $brackets = get_brackets_by_tournament_id($tournament->getId());
    $tournamnetTypes = get_tournament_types();
    require_once("tournament_edit.php");
}


else if($controllerChoice == 'update_bracket_info'){
    
    $bracket_name = filter_input(INPUT_POST, 'tournamentBracketName');
    $number_of_rounds = filter_input(INPUT_POST, 'rounds');
    $bracket_id = filter_input(INPUT_POST, 'bracket_id');
    
    // Loop through rounds 1 to 11
    for ($round = 1; $round <= 11; $round++) {
      // Set isActive based on the current round and number_of_rounds
      $isActive = ($round <= $number_of_rounds) ? 1 : 0;
      // Update bracket map list isActive for this round
      update_bracket_map_list_isActive($bracket_id, $round, $isActive);
    }
    update_bracket_info($bracket_id, $bracket_name, $number_of_rounds);
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    require_once("tournament_edit.php");
}


////////////////////////////////////////////////////////////////////////////////
// sends user to the tournament bracket when selected from tournament_list
else if ($controllerChoice == 'tournament_bracket') {

    $tournament_id = filter_input(INPUT_POST, 'tournamentId');
    $tournament = get_tournament_by_id($tournament_id);
    $roundArray = array();

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
        require_once("tournament_bracket.php");
    }
}

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




