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
require_once('../model/BracketMatch.php');
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
//checks to see if a user is an admin
if ($userLogedin->getUserTypeId() == 2) {
////////////////////////////////////////////////////////////////////////////////
// sends user to admin homepage
    if ($controllerChoice == 'admin') {
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '0';       
        require_once("admin.php");
    }
    
    
    
////////////////////////////////////////////////////////////////////////////////
// brings admin user to the user edit page (sends a non admin user to login)
    else if ($controllerChoice == 'user_profile') { //start user
        $user = get_user_by_id(filter_input(INPUT_POST, 'user_id'));
        require_once("user_profile_edit.php");
    }
    
    else if($controllerChoice == 'user_update'){
        
        $id = filter_input(INPUT_POST, 'userId');
        $switchFriendCode = filter_input(INPUT_POST, 'friendCode');
        $switchUsername = filter_input(INPUT_POST, 'switchUsername');
        $splashtag = filter_input(INPUT_POST, 'splashtag');
        $discordUsername = filter_input(INPUT_POST, 'discordUsername');
        update_user_by_admin($id, $switchFriendCode, $switchUsername, $splashtag, $discordUsername);
        
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '0';  
        require_once("admin.php");
    }
    
    else if($controllerChoice == 'user_deactivate'){
        $id = filter_input(INPUT_POST, 'user_id');
        update_user_isActive($id, 0);
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '0';  
        require_once("admin.php");
    }
    else if($controllerChoice == 'user_activate'){
        $id = filter_input(INPUT_POST, 'user_id');
        update_user_isActive($id, 1);
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '0';  
        require_once("admin.php");
    } //end user
    
    else if ($controllerChoice == 'team_details') { //start team 
        $team = get_team_by_id(filter_input(INPUT_POST, 'team_id'));
        $teamMembers = get_team_members($team);
        require_once("team_details_edit.php");
    }
    
    else if($controllerChoice == 'team_update'){
        
        $id = filter_input(INPUT_POST, 'teamId');
        $teamName = filter_input(INPUT_POST, 'teamName');
        $teamImageLink = filter_input(INPUT_POST, 'teamImageLink');
        if(filter_input(INPUT_POST, 'removeTeamImage') === 'on'){
            $teamImageLink = '';
        }
        
        update_team_by_admin($id, $teamName, $teamImageLink);
              
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '1';  
        require_once("admin.php");
    }
    
    else if($controllerChoice == 'team_deactivate'){
        $id = filter_input(INPUT_POST, 'team_id');
        update_team_isActive($id, 0);
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '1';  
        require_once("admin.php");
    }
    else if($controllerChoice == 'team_activate'){
        $id = filter_input(INPUT_POST, 'team_id');
        update_team_isActive($id, 1);
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '1';  
        require_once("admin.php");
    } //end team
    
    else if($controllerChoice == 'tournament_deactivate'){ //start tournament
        $id = filter_input(INPUT_POST, 'tournament_id');
        update_tournament_isActive($id, 0);
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '2';  
        require_once("admin.php");
    }
    else if($controllerChoice == 'tournament_activate'){
        $id = filter_input(INPUT_POST, 'tournament_id');
        update_tournament_isActive($id, 1);
        
        $users = get_users();
        $teams = get_teams();
        $tournaments = get_tournaments();
        
        $tab = '2';  
        require_once("admin.php");
    } //end tournament
    
    
    
////////////////////////////////////////////////////////////////////////////////
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
//redirects a non admin user to login
} else {
    require_once('../user_manager/user_login.php');
}




