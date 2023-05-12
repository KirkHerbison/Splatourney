<?php

require_once '../model/User.php';
require_once '../model/Team.php';
require_once '../model/Tournament.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/team_db.php');
require_once('../model/bracket_db.php');
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
$error_message_maplist = '';
$error_message_scores = '';
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
    $tab = 0;
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $matchList = get_matches_by_tournament_id($tournament_id);
    
    $roundExists = true;
    $roundArray = array();
    for ($roundNumber = 1; $roundExists == true; $roundNumber++) {
        if (check_round_exists_by_number($roundNumber, $tournament_id)) {
            $matches = get_matches_by_round_number($roundNumber, $tournament_id);
            $round = new Round($roundNumber, $matches);
            $roundArray[] = $round;
        } else {
            $roundExists = false;
        }
    }
    
    
    
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    require_once("tournament_edit.php");
}

// Sends User to a tournament details page
else if ($controllerChoice == 'details'){
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournament_id);
    require_once("tournament_details.php");
}

// Sends User to a tournament signup page
else if ($controllerChoice == 'tournament_signup'){
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournament_id);
    
    $teams = get_teams_by_captain_id($userLogedin->getId());
    
    require_once("tournament_signup.php");
}

// Validates signup
else if ($controllerChoice == 'signup_confirmation'){
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $team_id = filter_input(INPUT_POST, 'team_id');
    $tournament = get_tournament_by_id($tournament_id);

    if(!check_team_exists_in_tournament($team_id, $tournament_id)){
        add_tournament_team(get_lowest_seed_by_tournament_id($tournament_id), $team_id, $tournament_id);
        require_once("tournament_details.php");
    }else{
        $teams = get_teams_by_captain_id($userLogedin->getId());
        $error_message = 'Select A Team That Has Not Joined Yet';
        require_once("tournament_signup.php");
    }
    
    
   
}



// In the header when the user selects my teams
else if ($controllerChoice == 'my_tournament_list') {
    if ($userLogedin->getId() > 0) {
        $tournamentsJoined = get_tournaments_by_user_id($userLogedin->getId());
        $tournamentsOwned = get_tournaments_by_ownerId($userLogedin->getId());
        require_once("user_tournament_list.php");
    } else {
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
            
            $roundExists = true;
            $roundArray = array();
            for ($roundNumber = 1; $roundExists == true; $roundNumber++) {
                if (check_round_exists_by_number($roundNumber, $tournament->getId())) {
                    $matches = get_matches_by_round_number($roundNumber, $tournament->getId());
                    $round = new Round($roundNumber, $matches);
                    $roundArray[] = $round;
                } else {
                    $roundExists = false;
                }
            }
            
            
            $matchList = get_matches_by_tournament_id($tournament->getId());
            $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
            $maps = get_maps();
            $modes = get_modes();
            
            
            $teams = get_tournament_teams_by_tournament_id($tournament->getId());
            $tab = 0;
            
            
            require_once("tournament_edit.php");
        } else {
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
    $unformatedToday = new DateTime();
    $today = $unformatedToday->format('Y-m-d\TH:i');
    $startDatetime = new DateTime(filter_input(INPUT_POST, 'tournamentDeadline'));
    $deadline = new DateTime(filter_input(INPUT_POST, 'tournamentDateTime'));
    $difference = $startDatetime->diff($deadline);
    $tournamnetTypes = get_tournament_types();
    $tournamentId = filter_input(INPUT_POST, 'tournament_id');
    $tournament = get_tournament_by_id($tournamentId);

    $matchList = get_matches_by_tournament_id($tournamentId);
    $bracket = get_bracket_by_tournament_id($tournamentId);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    $tab = 0;

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
            $matchList = get_matches_by_tournament_id($tournamentId);
            $teams = get_tournament_teams_by_tournament_id($tournamentId);
            $bracket = get_bracket_by_tournament_id($tournamentId);
            $tournament = get_tournament_by_id($tournamentId);
            $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
            $maps = get_maps();
            $modes = get_modes();
            $tab = 0;
            require_once("tournament_edit.php");
        } else {
            
            $matchList = get_matches_by_tournament_id($tournament_id);
            $teams = get_tournament_teams_by_tournament_id($tournamentId);
            $bracket = get_bracket_by_tournament_id($tournamentId);
            $tournament = get_tournament_by_id($tournamentId);
            $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
            $maps = get_maps();
            $modes = get_modes();
            $tab = 0;
            require_once("edit.php");
        }
    }
} else if ($controllerChoice == 'insert_bracket') {

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
    
} else if ($controllerChoice == 'update_bracket_info') {

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
    $matchList = get_matches_by_tournament_id($tournament_id);
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    $tab = 1;
    require_once("tournament_edit.php");
}

else if ($controllerChoice == 'update_seeding') {

    $teamsArray = $_POST['team'];
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');

    $seedCount = 1;
    foreach ($teamsArray as $team) {  
        update_seeding_by_team_id_and_tournament_id($team, $tournament_id, $seedCount);
        $seedCount++;
    }

    $matchList = get_matches_by_tournament_id($tournament_id);
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    $tab = 1;
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

//deletes a tournament
else if ($controllerChoice == 'tournament_delete'){
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    
    delete_tournament_by_id($tournament_id);
    delete_tournament_results_by_tournament_id($tournament_id);
    delete_tournament_teams_by_tournament_id($tournament_id);
    
    
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $bracket_id = $bracket->getId();
    
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket_id);
    foreach($mapLists as $maplist){
        delete_bracket_map_list_map_by_bracket_match_list_id($maplist->getId());
    }
    delete_bracket_map_lists_by_bracket_id($bracket_id);
    
    $matchList = get_matches_by_tournament_id($tournament_id);
    foreach($matchList as $match){ 
        $chat = get_chat_by_match_id($match->getId());
        $chat_id = $chat->getId();
        delete_chat_messages_by_chat_id($chat_id);
        delete_chat_by_chat_id($chat_id);
    }
    delete_bracket_match_by_tournament_id($tournament_id);
    delete_bracket_by_tournament_id($tournament_id);
    require_once("tournament_register.php");
}

//updates the map list when a user saves a round
else if ($controllerChoice == 'update_maplist') {

    $maplist_id = filter_input(INPUT_POST, 'maplistId');
    $roundNumber = filter_input(INPUT_POST, 'roundNumber');

    $mode1 = filter_input(INPUT_POST, 'mode1');
    $mode2 = filter_input(INPUT_POST, 'mode2');
    $mode3 = filter_input(INPUT_POST, 'mode3');
    $mode4 = filter_input(INPUT_POST, 'mode4');
    $mode5 = filter_input(INPUT_POST, 'mode5');
    $mode6 = filter_input(INPUT_POST, 'mode6');
    $mode7 = filter_input(INPUT_POST, 'mode7');
    $mode8 = filter_input(INPUT_POST, 'mode8');
    $mode9 = filter_input(INPUT_POST, 'mode9');
    $mode10 = filter_input(INPUT_POST, 'mode10');
    $mode11 = filter_input(INPUT_POST, 'mode11');

    $map1 = filter_input(INPUT_POST, 'map1');
    $map2 = filter_input(INPUT_POST, 'map2');
    $map3 = filter_input(INPUT_POST, 'map3');
    $map4 = filter_input(INPUT_POST, 'map4');
    $map5 = filter_input(INPUT_POST, 'map5');
    $map6 = filter_input(INPUT_POST, 'map6');
    $map7 = filter_input(INPUT_POST, 'map7');
    $map8 = filter_input(INPUT_POST, 'map8');
    $map9 = filter_input(INPUT_POST, 'map9');
    $map10 = filter_input(INPUT_POST, 'map10');
    $map11 = filter_input(INPUT_POST, 'map11');

    $isValid = true;

    //check for best of 1
    if ($map1 > 0 && $mode1 > 0) {
        update_maplist_game($maplist_id, 1, $map1, $mode1);
    } else {
        if ($map1 == 0 && $mode1 == 0) {
            update_maplist_game($maplist_id, 1, 0, 0);
        } else {
            $error_message_maplist = 'Game 1 from round ' . $roundNumber . ' was not saved, please ensure map and mode are not set to NONE unless you want to delete the game';
            $isValid = false;
        }
    }

    //checking for best of 3
    if ($isValid && $map2 > 0 && $mode2 > 0 && $map3 > 0 && $mode3 > 0) {
        update_maplist_game($maplist_id, 2, $map2, $mode2);
        update_maplist_game($maplist_id, 3, $map3, $mode3);
    } else {
        if ($map2 == 0 && $mode2 == 0 && $map3 == 0 && $mode3 == 0) {
            update_maplist_game($maplist_id, 2, 0, 0);
            update_maplist_game($maplist_id, 3, 0, 0);
        } else {
            $error_message_maplist = 'Game 2 and game 3 from round ' . $roundNumber . ' were not saved, please ensure maps and modes are not set to NONE unless you want to delete the games';
            $isValid = false;
        }
    }

    //checking for best of 5
    if ($isValid && $map4 > 0 && $mode4 > 0 && $map5 > 0 && $mode5 > 0) {
        update_maplist_game($maplist_id, 4, $map4, $mode4);
        update_maplist_game($maplist_id, 5, $map5, $mode5);
    } else {
        if ($map4 == 0 && $mode4 == 0 && $map5 == 0 && $mode5 == 0) {
            update_maplist_game($maplist_id, 4, 0, 0);
            update_maplist_game($maplist_id, 5, 0, 0);
        } else {
            $error_message_maplist = 'Game 4 and game 5 from round ' . $roundNumber . ' were not saved, please ensure maps and modes are not set to NONE unless you want to delete the games';
            $isValid = false;
        }
    }

    //checking for best of 7
    if ($isValid && $map6 > 0 && $mode6 > 0 && $map7 > 0 && $mode7 > 0) {
        update_maplist_game($maplist_id, 6, $map6, $mode6);
        update_maplist_game($maplist_id, 7, $map7, $mode7);
    } else {
        if ($map6 == 0 && $mode6 == 0 && $map7 == 0 && $mode7 == 0) {
            update_maplist_game($maplist_id, 6, 0, 0);
            update_maplist_game($maplist_id, 7, 0, 0);
        } else {
            $error_message_maplist = 'Game 6 and game 7 from round ' . $roundNumber . ' were not saved, please ensure maps and modes are not set to NONE unless you want to delete the games';
            $isValid = false;
        }
    }


    //checking for best of 9
    if ($isValid && $map8 > 0 && $mode8 > 0 && $map9 > 0 && $mode9 > 0) {
        update_maplist_game($maplist_id, 8, $map8, $mode8);
        update_maplist_game($maplist_id, 9, $map9, $mode9);
    } else {
        if ($map8 == 0 && $mode8 == 0 && $map9 == 0 && $mode9 == 0) {
            update_maplist_game($maplist_id, 8, 0, 0);
            update_maplist_game($maplist_id, 9, 0, 0);
        } else {
            $error_message_maplist = 'Game 8 and game 9 from round ' . $roundNumber . ' were not saved, please ensure maps and modes are not set to NONE unless you want to delete the games';
            $isValid = false;
        }
    }

    //checking for best of 5
    if ($isValid && $map10 > 0 && $mode10 > 0 && $map11 > 0 && $mode11 > 0) {
        update_maplist_game($maplist_id, 10, $map10, $mode10);
        update_maplist_game($maplist_id, 11, $map11, $mode11);
    } else {
        if ($map10 == 0 && $mode10 == 0 && $map11 == 0 && $mode11 == 0) {
            update_maplist_game($maplist_id, 10, 0, 0);
            update_maplist_game($maplist_id, 11, 0, 0);
        } else {
            $error_message_maplist = 'Game 10 and game 11 from round ' . $roundNumber . ' were not saved, please ensure maps and modes are not set to NONE unless you want to delete the games';
        }
    }





    
    $tab = 2;
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    $matchList = get_matches_by_tournament_id($tournament_id);
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    require_once("tournament_edit.php");
}

//checks to see if tournament is over, ends the tournament, sets the results, and deactivates the tournament
else if($controllerChoice == 'finish_bracket'){
    
    
    $tournament_id = filter_input(INPUT_POST, 'tournament_id');
    
    $tournament = get_tournament_by_id($tournament_id);
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $bracket_id = $bracket->getId();        
    $totalRounds = $bracket->getNumberOfRounds();
    
    $totalGames = 0;
    
    for($i=0; $i < $totalRounds; $i++){
        
        $totalGames += pow(2, $totalRounds - ($i+1));
        
    }
    
    $currentGame = 1;
    
    $matches = array();
    
    for($i=1; $i <= $totalRounds; $i++){
        $gamesInRound = pow(2, $totalRounds - $i);
        $matches = get_matches_by_round_number($i, $bracket_id);
        for($j=1; $j <= $gamesInRound; $j++){

            $bracketMatch = get_math_by_match_number_and_touranemnt_id($currentGame ,$tournament_id);
            $bracket_match_list = get_bracket_map_list_by_round_and_bracket_id($bracket_id, $bracketMatch->getRound());
            $totalGames = get_map_count_by_map_list_id($bracket_match_list->getId());
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

            //sets the winner for the final round
            if($gamesInRound == 1){
                if($bracketMatch->getTeamOneWins() == $wins_needed_to_win){
                    insert_tournament_result($tournament_id, $bracket->getId(), $bracketMatch->getTeamOneId(), 1);
                    insert_tournament_result($tournament_id, $bracket->getId(), $bracketMatch->getTeamTwoId(), 2);
                }else{
                    insert_tournament_result($tournament_id, $bracket->getId(), $bracketMatch->getTeamOneId(), 2);
                    insert_tournament_result($tournament_id, $bracket->getId(), $bracketMatch->getTeamTwoId(), 1);
                }   
            }else{
                if($bracketMatch->getTeamOneWins() == $wins_needed_to_win){
                    insert_tournament_result($tournament_id, $bracket->getId(), $bracketMatch->getTeamTwoId(), ($gamesInRound + 1));
                }else{
                    insert_tournament_result($tournament_id, $bracket->getId(), $bracketMatch->getTeamOneId(), ($gamesInRound + 1));
                }  
            }  
            $currentGame++;   
        }
    } 
    update_tournament_isActive($tournament_id, 0);
    if ($userLogedin->getId() > 0) {
        $tournamentsOwned = get_tournaments_by_ownerId($userLogedin->getId());
        $tournamentsJoined = get_tournaments_by_user_id($userLogedin->getId());
        require_once("user_tournament_list.php");
    } else {
        require_once('../index.php');
    }
}

else if($controllerChoice == 'update_match_score'){
    
    $match = get_match_by_id(filter_input(INPUT_POST, 'match_id'));
    $team_one_score = (int)filter_input(INPUT_POST, 'teamOneScore');
    $team_two_score = (int)filter_input(INPUT_POST, 'teamTwoScore');
    
    $bracket_id = $match->getBracketId();
    $tournament_id = $match->getTournamentId();
    $bracket = get_bracket_by_tournament_id($tournament_id);
    $bracketMatch = get_math_by_match_number_and_touranemnt_id($match->getMatchNumber(),$tournament_id);
    $bracket_match_list = get_bracket_map_list_by_round_and_bracket_id($bracket_id, $bracketMatch->getRound());
    $totalGames =  get_map_count_by_map_list_id($bracket_match_list->getId());
    
    //for page load
    $tab = 2;
    $teams = get_tournament_teams_by_tournament_id($tournament_id);
    $tournament = get_tournament_by_id($tournament_id);
    $mapLists = get_bracket_map_lists_by_bracket_id($bracket->getId());
    $maps = get_maps();
    $modes = get_modes();
    
    //gets the number of wins needed for a match to be done
    $wins_needed_to_win = 1;
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
    
    if(!($team_one_score >= $wins_needed_to_win && $team_two_score >= $wins_needed_to_win)){


        //updates the scores
        update_team_one_score_by_match_id_and_number($match->getId(), $team_one_score);
        update_team_Two_score_by_match_id_and_number($match->getId(), $team_two_score);

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
            update_match_team_one($future_match,0, $bracket_id);

        }
        else{
            update_match_team_two($future_match,0,$bracket_id);
        }

        //if team one wins set as winner
        if($team_one_score >= $wins_needed_to_win){
            //updates the team for next round
            if(fmod($next_position, 1) !== 0.0){
                update_match_team_one($future_match,$match->getTeamOneId(), $bracket_id);      
            }
            else{
                update_match_team_two($future_match,$match->getTeamOneId(),$bracket_id);
            }
        }

        //if team two wins set as winner
        if($team_two_score >= $wins_needed_to_win){
            //updates the team for next round
            if(fmod($next_position, 1) !== 0.0){
                update_match_team_one($future_match,$match->getTeamTwoId(), $bracket_id);      
            }
            else{
                update_match_team_two($future_match,$match->getTeamTwoId(),$bracket_id);
            }
        }  
        
        $matchList = get_matches_by_tournament_id($tournament_id);
        require_once("tournament_edit.php");
    }
    else{
        $matchList = get_matches_by_tournament_id($tournament_id);
        $error_message_scores = "A match can only have 1 winner, scores not saved";
        require_once("tournament_edit.php");
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




