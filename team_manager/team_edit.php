<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" type="text/css" href="styles/table.css">
<link rel="stylesheet" type="text/css" href="styles/team_details.css">
    <div class="divider">    
        <span class="team-name"><?php echo $team->getTeamName(); ?></span>
    </div>
<div class="team-display">
    <img src="<?php echo $team->getTeamImageLink(); ?>" alt="<?php echo $team->getTeamName(); ?> Image"/>
    <?php if(isset($userLogedin) && $userLogedin->getId() == $team->getCaptainUserId()){ ?>
        <form class='edit-form' action="team_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="edit_team_details" /> 
            <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                <div class="edit-button">
                    <input class="center-button"   type="submit" value="Edit Name Or Image">
                </div>
        </form>
    <?php } ?>
</div>

<br>
    <h2>Member List: </h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Switch Username</th>
                <th>Splashtag</th>
                <th>Switch Friend Code</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teamMembers as $user) : ?>
                <tr>
                    <td><?php echo $user->getUsername(); ?></td>
                    <td><?php echo $user->getSplashtag(); ?></td>
                    <td><?php echo $user->getSwitchFriendCode(); ?></td>
                    <td>
                        <?php if ($user->getId() != $team->getCaptainUserId()) { ?>
                            <?php if(isset($userLogedin) && $userLogedin->getId() == $team->getCaptainUserId()){ ?>
                                <form action="team_manager/index.php" method="POST">
                                    <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                                    <input type="hidden" name="controllerRequest" value="delete_team_member" /> 
                                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            <?php }?>
                            <?php if(isset($userLogedin) && $user->getId() == $userLogedin->getId() ){ ?>
                                <form action="team_manager/index.php" method="POST">
                                    <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                                    <input type="hidden" name="controllerRequest" value="delete_team_member" /> 
                                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                                    <input type="submit" value="Delete">
                                </form>
                            <?php }?>
                        
                        <?php } else {?>
                            Team Captain
                        <?php }?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
<h3 class="error_message"><?php echo $error_message ?></h3>
    <?php if(isset($userLogedin) && $userLogedin->getId() == $team->getCaptainUserId()){ ?>
        <form class='search-form' action="team_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="add_team_member" /> 
            <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                <label>Add Member By Username:</label>
                <input class="team-name-input" type="text" name="new_member_username">
                <div class="search-button">
                    <input  type="submit" value="Add">
                </div>
            <br>
        </form>
    <?php } ?>


<?php require_once '../view/footer.php'; ?>