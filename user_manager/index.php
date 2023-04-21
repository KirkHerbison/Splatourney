<?php
require_once '../model/User.php';
require_once('../model/database.php');
require_once('../model/user_db.php');
require_once ('../model/Result.php');
require_once ('../model/Tournament.php');
require_once ('../model/tournament_db.php');
require_once ('../model/team_db.php');
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

// Bring user to login page when Login is clicked on header 
if ($controllerChoice == 'login_user') {
    if (isset($_SESSION['userLogedin'])) {
        $userLogedin = $_SESSION['userLogedin'];
    }
    require_once("user_login.php");
}

// sends the user to the registration page if register is selected in the header
else if ($controllerChoice == 'user_register') {
    $error_message = "";
    $user_id = -1;
    require_once("user_register.php");
}

// sends the user to the registration page if register is selected in the header
else if ($controllerChoice == 'user_edit') {
    $error_message = "";
    require_once("user_register.php");
}

//Logs the user out and returns the to user_login
else if ($controllerChoice == 'logout') {
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
    $error_message = '';
    session_destroy();
    $_SESSION = array();
    include("user_login.php");
}

////////////////////////////////////////////////////////////////////////////////

//Validates user login and sends to a confirmation page
//if the login does not validate it returns an error to the login page
else if ($controllerChoice == 'validate_login') {
    $email = filter_input(INPUT_POST, 'email');
    $pass = filter_input(INPUT_POST, 'pass');
    if ($email == '' || $pass == '') {
        $error_message = "Please enter a valid email and password";
        include('user_login.php');
    } else {
        $user = get_user_by_email_password($email, $pass);
        $ID = -1;
        if ($user != null) {$ID = $user->getId();} 
        if ($ID > 0) {
            $login_message = "Login Succesful";
            $_SESSION['userLogedin'] = $user;
            $userLogedin = $_SESSION['userLogedin'];
            include('user_login_confirmation.php');
        } else {
            $error_message = "Incorrect email or password";
            include('user_login.php');
        }
    }
}

////////////////////////////////////////////////////////////////////////////////

// brings admin user to the user edit page (sends a non admin user to login)
elseif ($controllerChoice == 'user_profile') {
    $user = get_user_by_id(filter_input(INPUT_POST, 'user_id'));
    require_once("user_profile.php");
    
}

//Sends admin user to the list of customers
//If a non admin attempts they will be sent to user_login
else if ($controllerChoice == 'list_users') {
    $users = get_users();
    include("user_list.php");
}

//lists users results
else if ($controllerChoice == 'user_results') {
    $ID = filter_input(INPUT_POST, 'user_id');
    $user = get_user_by_id($ID);
    $results = get_user_results($ID);
    include("user_results.php");
}

//Finds users bassed on a last name search and sends the new list to the admin page
else if ($controllerChoice == 'username_search') {
    $users = search_users(filter_input(INPUT_POST, 'username_search'));
    include("user_list.php");
}

////////////////////////////////////////////////////////////////////////////////

// updates a user from the edit page and sends the admin back to the user list
elseif ($controllerChoice == 'user_save') {

    if (filter_input(INPUT_POST, 'isActive') == 'on') {
        $isActive = 1;
    } else {
        $isActive = 0;
    }

    $user = new User(
            filter_input(INPUT_POST, 'ID'),
            filter_input(INPUT_POST, 'roleID'),
            filter_input(INPUT_POST, 'firstName'),
            filter_input(INPUT_POST, 'lastName'),
            filter_input(INPUT_POST, 'email'),
            filter_input(INPUT_POST, 'password'),
            filter_input(INPUT_POST, 'address'),
            filter_input(INPUT_POST, 'city'),
            filter_input(INPUT_POST, 'state'),
            filter_input(INPUT_POST, 'zip'),
            filter_input(INPUT_POST, 'phone'),
            $isActive
    );

    update_user($user);
    $users = get_users();
    require_once("user_list.php");
}

//Sends user to a confirmation page if the form validates
//Does logic to test, sends back to register and displays
//error if form will not validate
elseif ($controllerChoice == 'user_register_confirmation') {
    
    $dislpay = filter_input(INPUT_POST, 'showName');
    if(filter_input(INPUT_POST, 'showName') == 'on'){
        $displayName = 1;
    }

    $user = new User(
            -1,
            1,
            filter_input(INPUT_POST, 'emailAddress'),
            filter_input(INPUT_POST, 'username'),
            filter_input(INPUT_POST, 'password'),
            filter_input(INPUT_POST, 'firstName'),
            filter_input(INPUT_POST, 'lastName'),
            preg_replace("/[^0-9]/", "",filter_input(INPUT_POST, 'friendCode')),
            filter_input(INPUT_POST, 'switchUsername'),
            filter_input(INPUT_POST, 'splashtag'),
            filter_input(INPUT_POST, 'discordUsername'),
            null,
            true,
            $dislpay
    );

    if ($user->getFirstName() == null || $user->getLastName() == null || $user->getEmailAddress() == null || $user->getPassword() == null || $user->getUsername() == null) {
        $error_message = "Invalid registration, please fill out first name, last name, email, username, and password";
        require_once("user_register.php");
    } elseIf (check_user_email($user->getEmailAddress())) {
        $error_message = "Invalid registration, this email is already in use";
        require_once("user_register.php");
    } elseIf (check_discord_username($user->getDiscordUsername())) {
        $error_message = "Invalid registration, this discord username is already in use";
        require_once("user_register.php");
    } elseIf (check_splashtag($user->getSplashtag())) {
        $error_message = "Invalid registration, this splashtag is already in use";
        require_once("user_register.php");
    } elseIf (check_switch_friend_code($user->getSwitchFriendCode())) {
        $error_message = "Invalid registration, this friend code is already in use";
        require_once("user_register.php");
    } elseIf (check_username($user->getUsername())) {
        $error_message = "Invalid registration, this username is already in use";
        require_once("user_register.php");
    } else {
        add_user($user);
        require_once("login.php");
    }
}

//Sends user to a confirmation page if the form validates
//Does logic to test, sends back to register and displays
//error if form will not validate
elseif ($controllerChoice == 'user_save_confirmation') {

    $displayName = 0;
    if(filter_input(INPUT_POST, 'showName') == 'on'){
        $displayName = 1;
    }

    $user = new User(
            $userLogedin->getId(),
            $userLogedin->getUserTypeId(),
            filter_input(INPUT_POST, 'emailAddress'),
            filter_input(INPUT_POST, 'username'),
            filter_input(INPUT_POST, 'password'),
            filter_input(INPUT_POST, 'firstName'),
            filter_input(INPUT_POST, 'lastName'),
            preg_replace("/[^0-9]/", "",filter_input(INPUT_POST, 'friendCode')),
            filter_input(INPUT_POST, 'switchUsername'),
            filter_input(INPUT_POST, 'splashtag'),
            filter_input(INPUT_POST, 'discordUsername'),
            null,
            true,
            $displayName
    );

    if ($user->getFirstName() == null || $user->getLastName() == null || $user->getEmailAddress() == null || $user->getPassword() == null || $user->getUsername() == null) {
        $error_message = "Invalid registration, please fill out first name, last name, email, username, and password";
        require_once("user_register.php");
    } elseIf ($userLogedin->getEmailAddress() != $user->getEmailAddress() && check_user_email($user->getEmailAddress())) {
        $error_message = "Invalid registration, this email is already in use";
        require_once("user_register.php");
    } elseIf ($userLogedin->getDiscordUsername() != $user->getDiscordUsername() && check_discord_username($user->getDiscordUsername())) {
        $error_message = "Invalid registration, this discord username is already in use";
        require_once("user_register.php");
    } elseIf ($userLogedin->getSplashtag() != $user->getSplashtag() && check_splashtag($user->getSplashtag())) {
        $error_message = "Invalid registration, this splashtag is already in use";
        require_once("user_register.php");
    } elseIf ($userLogedin->getSwitchFriendCode() != $user->getSwitchFriendCode() && check_switch_friend_code($user->getSwitchFriendCode())) {
        $error_message = "Invalid registration, this friend code is already in use";
        require_once("user_register.php");
    } elseIf ($userLogedin->getUsername() != $user->getUsername() && check_username($user->getUsername())) {
        $error_message = "Invalid registration, this username is already in use";
        require_once("user_register.php");
    } else {
        update_user($user);
        $confirmation_message = "Your changes have been saved";
        $_SESSION['userLogedin'] = $user;
        $userLogedin = $_SESSION['userLogedin'];
        require_once("user_register.php");
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
    echo "<h3> File:  user_manager/index.php </h3>";
    require_once '../view/footer.php';
}
?>
