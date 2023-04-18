<?php

require_once '../model/User.php';
require_once '../model/Team.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/team_db.php');
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

// sends user to the create team page from the header
if ($controllerChoice == 'create_team') {
    if (isset($_SESSION['userLogedin'])) {
        require_once("team_register.php");
    } else {
        require_once("../user_manager/user_login.php");
    }
}

// In the header when the user clicks team list
else if ($controllerChoice == 'team_list') {
    $teams = get_teams();
    require_once("team_list.php");
}

// team list for a different user
else if ($controllerChoice == 'user_team_list') {
    $userId = filter_input(INPUT_POST, 'userId');
    $teams = get_teams_by_user_id($userId);
    require_once("team_list.php");
}

// In the header when the user selects my teams
else if ($controllerChoice == 'my_team_list') {
    $teams = get_teams_by_user_id($userLogedin->getId());
    require_once("user_team_list.php");
}


////////////////////////////////////////////////////////////////////////////////

// Creates a team when the user hits the create team button on in team_register.php
else if ($controllerChoice == 'team_register_confirmation') {
    if (isset($_SESSION['userLogedin'])) {
        $userLogedin = $_SESSION['userLogedin'];
        $imageValid = true;

        $teamToCreate = new Team(
                null,
                $userLogedin->getID(),
                $userLogedin->getUsername(),
                filter_input(INPUT_POST, 'teamName'),
                'test for now',
                1
        );

        if ($teamToCreate->getTeamName() == null || $teamToCreate->getTeamName() == "") {
            $error_message = "Please enter a team name.";
            require_once("team_register.php");
        } else if (check_if_team_exists($teamToCreate) != null) {
            $error_message = "You have already created a team under this name.";
            require_once("team_register.php");
        } else {
            
            if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) { // start for image upload
                $target_dir = "../images/team_images/"; // this is the initial file path to my images folder
                
                //this creates a unique identity for the image, something like teamImage_1236781236.php
                //uniqueid() gets a random number bassed on current time
                //.path info gets the file type (.jpg, .jpeg, .png [or invalid files])
                $image_name = 'teamImage_' . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 

                $target_file = $target_dir . $image_name;// this combines the ../images/ with the image name on the end
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // gets file type for validation
                
                
                if (in_array($imageFileType, array('jpg', 'jpeg', 'png'))) { // verifys the file type is valid
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) { //attempts to put file into folder
                        $teamToCreate->setTeamImageLink($image_name); //database call to put link into database
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
                $teamId = add_team($teamToCreate);
                $team = get_team_by_id($teamId);
                add_team_member($userLogedin, $team);
                $teamMembers = get_team_members($team);
                require_once 'team_edit.php';
            } else {
                require_once("team_register.php");
            }
        }
    }
}

// In team_edit when the user clicks the Add Member button
else if ($controllerChoice == 'add_team_member') {
    $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
    if (check_username(filter_input(INPUT_POST, 'new_member_username'))) {
        $user = get_user_by_username(filter_input(INPUT_POST, 'new_member_username'));

        if (check_if_member_exists($user, $team) != null) {
            $error_message = "This user is already on your roster.";
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        } else if (check_if_member_is_not_active($user, $team) != null) {
            update_team_member_isActive($user, $team);
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        } else {
            add_team_member($user, $team);
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        }
    } else {
        $error_message = "This user does not exist.";
        $teamMembers = get_team_members($team);
        require_once("team_edit.php");
    }
}

// In team_edit when the user clicks the delete member button
else if ($controllerChoice == 'delete_team_member') {
    $user = get_user_by_id(filter_input(INPUT_POST, 'user_id'));
    $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
    remove_team_member($user, $team);
    $teamMembers = get_team_members($team);
    require_once("team_edit.php");
}

//Finds teams bassed on a name search and sends a list back to the list page
else if ($controllerChoice == 'team_search_by_name') {
    $teams = search_teams(filter_input(INPUT_POST, 'team_search'));
    include("team_list.php");
}


////////////////////////////////////////////////////////////////////////////////

// In user_team_list when the user selects edit
else if ($controllerChoice == 'edit_selected_team') {
    $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
    $teamMembers = get_team_members($team);
    require_once 'team_edit.php';
}

// In user_team_list when the user selects delete
else if ($controllerChoice == 'delete_team') {
    remove_team(filter_input(INPUT_POST, 'team_id'));
    $teams = get_teams_by_user_id($userLogedin->getId());
    require_once("user_team_list.php");
}

// In user_team_list when the user selects activate
else if ($controllerChoice == 'activate_team') {
    activate_team(filter_input(INPUT_POST, 'team_id'));
    $teams = get_teams_by_user_id($userLogedin->getId());
    require_once("user_team_list.php");
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
