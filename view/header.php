<!DOCTYPE html>

<html>
    <!-- the head section -->

    <head>
        <title>Splatourey</title>
        <!-- Change the base href  to the correct URL!!!!! -->     
        <base href="http://localhost/projects/Splatourney/">
        <link rel="stylesheet" type="text/css" href="styles/main.css">
        <link rel="stylesheet" type="text/css" href="styles/header_nav.css">
         

    </head>

    <!-- the body section -->
    <body>
        <header>
            <h1 id="header">Splatourney <a href="user_manager?controllerRequest=logout">
            <?php if ($userLogedin->getEmailAddress() != '') {echo 'Logout';}?>
            </a></h1>
        </header>
        <nav>
            <ul id="header_ul">
                <li>
                    <a href="" >Home</a>
                </li>
                <li>
                    <a href="user_manager/index.php?controllerRequest=user_register">Register</a>
                </li>
                <li>
                    <a href="user_manager?controllerRequest=login_user">Login</a>
                </li>
                <li>
                    <a href="user_manager?controllerRequest=list_users">User List</a>
                </li>
                <li>
                    <a href="team_manager?controllerRequest=team_list">Team List</a>
                </li>  
                <li>
                    <a href="tournament_manager?controllerRequest=map_list">Map List</a>
                </li>
                <li>
                    <a href="tournament_manager?controllerRequest=tournament_list">Tournament List</a>
                </li>
                <?php if ($userLogedin->getID() != null) { ?>
                <li>
                    <a href="team_manager?controllerRequest=create_team">Create Team</a>
                </li>
                <li>
                    <a href="team_manager?controllerRequest=my_team_list">My Teams</a>
                </li>
                <li>
                    <a href="tournament_manager?controllerRequest=tournament_register">Create Tournament</a>
                </li>
                <?php }?>
            </ul>
        </nav>
        <main>





