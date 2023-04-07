<?php require_once '../view/header.php'; ?> 

<h1><?php echo $team->getTeamName(); ?></h1>
    <br>
    <p>Member List: </p>
    <table>
        <tr>
            <th>Switch Username</th>
            <th>Splashtag</th>
            <th>Switch Friend Code</th>
        </tr>
        <?php foreach ($teamMembers as $user) : ?>
            <tr>
                <td><?php echo $user->getUsername(); ?></td>
                <td><?php echo $user->getSplashtag(); ?></td>
                <td><?php echo $user->getSwitchFriendCode(); ?></td>
                <td>
                    <?php if ($user->getId() != $team->getCaptainUserId()) { ?>
                    <form action="team_manager/index.php" method="POST">
                        <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                        <input type="hidden" name="controllerRequest" value="delete_team_member" /> 
                        <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                        <input type="submit" value="Delete">
                    </form>
                    <?php } else {?>
                        Team Captain
                    <?php }?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <div>
        <p>Add Member By Username: </p>
        <form action="team_manager/index.php" method="POST">
            <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>"/> 
            <input type="hidden" name="controllerRequest" value="add_team_member" /> 
            <input type="text" name="new_member_username">
            <input type="submit" value="Add">
        </form>
    </div>
    <br>

<?php require_once '../view/footer.php'; ?>