<?php require_once '../view/header.php'; ?> 

<h1>My Team List</h1>
    <br>
    <p>Team List: </p>
    <table>
        <tr>
            <th>Team Name</th>
            <th>Edit</th>
            <th>Delete or Activate</th>
        </tr>
        <?php foreach ($teams as $team) : ?>
            <tr>
                <td><?php echo $team->getTeamName(); ?></td>
                <td>
                    <?php if ($team->getIsActive() == 1) { ?>
                    <form action="team_manager/index.php" method="POST">
                        <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                        <input type="hidden" name="controllerRequest" value="edit_selected_team" /> 
                        <input type="submit" value="Edit">
                    </form>
                    <?php }?>
                </td>
                <td>
                    <?php if ($team->getIsActive() == 1) { ?>
                    <form action="team_manager/index.php" method="POST">
                        <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                        <input type="hidden" name="controllerRequest" value="delete_team" /> 
                        <input type="submit" value="Delete">
                    </form>
                    <?php } else {?>
                        <form action="team_manager/index.php" method="POST">
                        <input type="hidden" name="team_id" value="<?php echo $team->getId(); ?>" /> 
                        <input type="hidden" name="controllerRequest" value="activate_team" /> 
                        <input type="submit" value="Activate">
                    </form>
                    <?php }?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>

<?php require_once '../view/footer.php'; ?>
