
<?php require_once '../view/header.php'; ?> 

<script src="js/hrefLinks.js"></script>
<script>
    $(function () {
        $("#tabs").tabs();
        console.log("tabs is loading");
        $("#tabs").tabs({ active: <?php echo $tab;?> });
    });
</script>
<link rel="stylesheet" type="text/css" href="styles/table.css">




<div id="tabs">
    <ul>
        <li><a href="#tabs-1" >Users</a></li>
        <li><a href="#tabs-2" >Teams</a></li>
        <li><a href="#tabs-3" >Tournaments</a></li>
    </ul>


    <div id="tabs-1">
        <h1>User List</h1>
        <form action="user_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="username_search" /> 
            <br>
            <div class="textbox-group">
                <label>Search by last username:</label>
                <input type="text" name="username_search">
            </div>
            <br>
            <div class="search-button">
                <input type="submit" value="Search">
            </div>
            <br>
        </form>

        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><p><?php echo $user->getId(); ?></p></td>
                            <td><p><?php
                                    if ($user->getDisplayName() == 1) {
                                        echo $user->getFirstName();
                                        ?> <?php
                                        echo $user->getLastName();
                                    }
                                    ?></p></td>
                            <td><p><?php echo $user->getUsername(); ?></p></td>
                            <td>
                                <form action="admin_manager/index.php" method="POST">
                                    <input type="hidden" name="controllerRequest" value="user_profile" /> 
                                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                    <input class="button-top" type="submit" value="View Profile">
                                </form>
                                <?php if($user->getIsActive() == 1){ ?>
                                <form action="admin_manager/index.php" method="POST">
                                    <input type="hidden" name="controllerRequest" value="user_deactivate" /> 
                                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                    <input type="submit" value="deactivate">
                                </form>
                                <?php }else{ ?>
                                <form action="admin_manager/index.php" method="POST">
                                    <input type="hidden" name="controllerRequest" value="user_activate" /> 
                                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                    <input type="submit" value="Activate">
                                </form>
                                <?php } ?>
                            </td>
                        </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    
    
    <div id="tabs-2">
        <h1>Team List</h1>
        <form action="team_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="team_search_by_name" /> 
            <br>
            <div class="textbox-group">
                <label>Search by team name:</label>
                <input type="text" name="team_search">
            </div>
            <br>
            <div class="search-button">
                <input type="submit" value="Search">
            </div>
            <br>
        </form>

        <table class="content-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Team Captain</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
<?php foreach ($teams as $team) : ?>
                <tr>
                    <td><p><?php echo $team->getId(); ?></p></td>
                    <td><p><?php echo $team->getTeamName(); ?></p></td>
                    <td><p><?php echo $team->getTeamCaptainName(); ?></p></td>
                    <td>
                        <form action="team_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="user_profile" /> 
                            <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>">
                            <input class="button-top" type="submit" value="View Details">
                        </form>
                        <?php if($team->getIsActive() == 1){ ?>
                        <form action="admin_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="team_deactivate" /> 
                            <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>">
                            <input type="submit" value="deactivate">
                        </form>
                        <?php }else{ ?>
                        <form action="admin_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="team_activate" /> 
                            <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>">
                            <input type="submit" value="Activate">
                        </form>
                        <?php } ?>
                    </td>
                </tr>
<?php endforeach; ?><tbody>
        </table>
    </div>
    
    
    
    <div id="tabs-3" >
        <h1>Tournament List</h1>
        <form action="team_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="tournament_search_by_name" /> 
            <br>
            <div class="textbox-group">
                <label>Search by tournament name:</label>
                <input type="text" name="tournament_search">
            </div>
            <br>
            <div class="search-button">
                <input type="submit" value="Search">
            </div>
            <br>
        </form>

        <table class="content-table">
            <thead>
            <tr>
                <th>Name</th>
                <th>date</th>
                <th>detail</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>

<?php foreach ($tournaments as $tournament) : ?>
                <tr>
                    <td><?php echo $tournament->getTournamentName(); ?></td>
                    <td><?php echo $tournament->getTournamentDate(); ?></td>
                    <td>
                        <form action="bracket_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="bracket" />
                            <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                            <input type="submit" value="Bracket">
                        </form>
                    </td>
    <?php if ($tournament->getTournamentOwnerId() == $userLogedin->getId()) { ?>
                        <td>
                            <form action="team_manager/index.php" method="POST">
                                <input type="hidden" name="controllerRequest" value="tournament_edit" /> 
                                <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                                <input type="submit" value="Edit">
                            </form>
                                                    <form action="user_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="tournmanet_delete" /> 
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>">
                            <input type="submit" value="Delete">
                        </form>
                            
                        </td>
                        
                <?php } ?>
                </tr>
<?php endforeach; ?>
                                
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../view/footer.php'; ?>

