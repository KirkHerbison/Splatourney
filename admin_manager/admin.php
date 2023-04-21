
<?php require_once '../view/header.php'; ?> 

<link rel="stylesheet" type="text/css" href="styles/table.css">
<link rel="stylesheet" type="text/css" href="styles/admin.css">

<script src="js/hrefLinks.js"></script>
<script>
    $(document).ready(function() {  
        $("#tabs").tabs();
        $("#tabs").tabs({ active: <?php echo $tab;?> });         
        var activeTab = <?php echo $tab;?>; // replace with your variable that holds the ID of the active tab
        console.log(activeTab);
        $(".ui-tabs-nav").show();
        if (activeTab === 0) {
            $("#user-search-div").show();
            $("#team-search-div").hide();
            $("#tournament-search-div").hide();
        } else if (activeTab === 1) {
            $("#user-search-div").hide();
            $("#team-search-div").show();
            $("#tournament-search-div").hide();
        } else if (activeTab === 2) {
            $("#user-search-div").hide();
            $("#team-search-div").hide();
            $("#tournament-search-div").show();
        }

    });
</script>

<div id="user-search-div">
          
        <form class='search-form' action="admin_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="username_search" /> 
            <label>Search by username:</label>
            <input  class="team-name-input" type="text" name="username_search">
            <div class="search-button">
                <input type="submit" value="Search">
            </div>
        </form>
</div>
<div id="team-search-div">
          <form class='search-form' action="admin_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="team_search_by_name" /> 
            <label>Search by team name:</label>
            <input class="team-name-input" type="text" name="team_search">
            <div class="search-button">
                <input type="submit" value="Search">
            </div>
            <br>
        </form>
</div>
<div id="tournament-search-div">
         <form class='search-form' action="admin_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="tournament_search_by_name" /> 
            <label>Search by tournament name:</label>
            <input class="team-name-input" type="text" name="tournament_search">
            <div class="search-button">
                <input type="submit" value="Search">
            </div>
            <br>
        </form>
</div>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1" >Users</a></li>
        <li><a href="#tabs-2" >Teams</a></li>
        <li><a href="#tabs-3" >Tournaments</a></li>
    </ul>


    <div id="tabs-1">
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
                        <form action="admin_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="team_details" /> 
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
        <table class="content-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tournament Name</th>
                <th>date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

<?php foreach ($tournaments as $tournament) : ?>
                <tr>
                    <td><p><?php echo $tournament->getId(); ?></p></td>
                    <td><p><?php echo $tournament->getTournamentName(); ?></p></td>
                    <td><p><?php echo $tournament->getTournamentDate(); ?></p></td>
                    <?php if ($tournament->getTournamentOwnerId() == $userLogedin->getId()) { ?>
                    <td>
                        <form action="admin_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="tournament_details" /> 
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>">
                            <input class="button-top" type="submit" value="View Details">
                        </form>
                        <?php if($tournament->getIsActive() == 1){ ?>
                        <form action="admin_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="tournament_deactivate" /> 
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>">
                            <input type="submit" value="deactivate">
                        </form>
                        <?php }else{ ?>
                        <form action="admin_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="tournament_activate" /> 
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>">
                            <input type="submit" value="Activate">
                        </form>
                        <?php } ?>
                    </td>                      
                    <?php } ?>
                </tr>
<?php endforeach; ?>
                                
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../view/footer.php'; ?>

