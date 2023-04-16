<!DOCTYPE html>

<html>
    <!-- the head section -->

    <head>
        <title>Splatourey</title>
        <!-- Change the base href  to the correct URL!!!!! -->     
        <base href="http://localhost/projects/Splatourney/">
        <link rel="stylesheet" type="text/css" href="styles/main.css">
        <link rel="stylesheet" type="text/css" href="styles/header_nav.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://use.typekit.net/naj2zsa.css"> <!-- Used for Header font -->
        <link rel="stylesheet" href="styles/slicknav.css" />
        <script src="js/jquery.slicknav.min.js"></script>
      
    </head>
    


    <!-- the body section -->
    <body>
        <header>
            <img style=" max-height: 80px; max-width: 80px" src="images/assets/Private_Battle.png" alt="logo" />
            <h1 id="header">Splatourney </h1>
        </header>
        <div id="nav-wrapper">
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
                    <a href="tournament_manager?controllerRequest=tournament_list">Tournament List</a>
                </li>          
                <li>
                    <a href="user_manager?controllerRequest=list_users">User List</a>
                </li>
                <li>
                    <a href="team_manager?controllerRequest=team_list">Team List</a>
                </li>    
                <?php if ($userLogedin->getID() != null) { ?>                
                    <li>
                        <a href="team_manager?controllerRequest=my_team_list">My Teams</a>
                    </li>
                    <li>
                        <a href="team_manager?controllerRequest=create_team">Create Team</a>
                    </li>
                    <li>
                        <a href="tournament_manager?controllerRequest=tournament_register">Create Tournament</a>
                    </li>
                <?php }?>
                <?php if ($userLogedin->getUserTypeId() === 2) { ?>
                    <li>
                        <a href="admin_manager?controllerRequest=admin">Admin</a>
                    </li>
                <?php }?>                    
                <?php if ($userLogedin->getEmailAddress() != '') { ?>
                    <li style="float: right;">
                        <a href="user_manager?controllerRequest=logout">Logout</a>
                    </li>
                <?php }?>

            </a>
            </ul>

        </nav>
        </div>
        <script>
            $(function(){
                    $('#header_ul').slicknav({
                                label:'',
                                prependTo:'#nav-wrapper'
                    });
            });
        </script>
        <main>





