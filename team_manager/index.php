<?php

require_once '../model/User.php';
require_once '../model/Team.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once('../model/team_db.php');

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

// sends user to the creat team page from the header
if ($controllerChoice == 'create_team') {
    if (isset($_SESSION['userLogedin'])) {
        require_once("team_register.php");
    } else {
        require_once("../user_manager/user_login.php");
    }
}

// Creates a team when the user hits the create team button on in team_register.php
else if ($controllerChoice == 'team_register_confirmation') {
    if (isset($_SESSION['userLogedin'])) {
        $userLogedin = $_SESSION['userLogedin'];

        $teamToCreate = new Team(
                null,
                $userLogedin->getID(),
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
            $teamId = add_team($teamToCreate);
            $team = get_team_by_id($teamId);
            add_team_member($userLogedin, $team);
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        }
    }
}


// In team_edit when the user clicks the Add Member button
else if ($controllerChoice == 'add_team_member') {
    $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
    if(check_username(filter_input(INPUT_POST, 'new_member_username'))){
        $user = get_user_by_username(filter_input(INPUT_POST, 'new_member_username'));
        
        if (check_if_member_exists($user,$team) != null) {
            $error_message = "This user is already on your roster.";
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        } else if (check_if_member_is_not_active($user,$team) != null) {
            update_team_member_isActive($user, $team);
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        } else {
            add_team_member($user, $team);
            $teamMembers = get_team_members($team);
            require_once 'team_edit.php';
        }    
    }
    else{
        $error_message = "This user does not exist.";
        $teamMembers = get_team_members($team);
        require_once("team_edit.php");
    } 
}

// In team_edit when the user clicks the delete member button
else if ($controllerChoice == 'delete_team_member'){   
    $user = get_user_by_id(filter_input(INPUT_POST, 'user_id'));
    $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
    remove_team_member($user, $team);
    $teamMembers = get_team_members($team);
    require_once("team_edit.php");
}

// In the header when the user selects my teams
else if ($controllerChoice == 'team_list'){   
    $teams = get_teams_by_user_id($userLogedin->getId());
    require_once("user_team_list.php");
}

// In user_team_list when the user selects edit
else if ($controllerChoice == 'edit_selected_team'){   
    $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
    $teamMembers = get_team_members($team);
    require_once 'team_edit.php';
}

// In user_team_list when the user selects delete
else if ($controllerChoice == 'delete_team'){
    remove_team(filter_input(INPUT_POST, 'team_id'));
    $teams = get_teams_by_user_id($userLogedin->getId());
    require_once("user_team_list.php");
}

// In user_team_list when the user selects activate
else if ($controllerChoice == 'activate_team'){
    activate_team(filter_input(INPUT_POST, 'team_id'));
    $teams = get_teams_by_user_id($userLogedin->getId());
    require_once("user_team_list.php");
}

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
