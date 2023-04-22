<?php require_once '../view/header.php'; ?> 

<link rel="stylesheet" type="text/css" href="styles/table.css">
<link rel="stylesheet" type="text/css" href="styles/results.css">

<?php if($tournamentsOwned != null){ ?>

<h1>Owned Tournaments</h1>

    <table class="content-table">
        <thead>
            <tr>
                <th>Tournament Name</th>
                <th>Edit</th>
                <th>Delete or Activate</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tournamentsOwned as $tournament) : ?>
            <tr>
                <td><?php echo $tournament->getTournamentName(); ?></td>
                <td>
                    <?php if ($tournament->getIsActive() === 1) { ?>
                    <form action="tournament_manager/index.php" method="POST">
                        <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>" /> 
                        <input type="hidden" name="controllerRequest" value="edit_my_tournament" /> 
                        <input type="submit" value="Edit">
                    </form>
                    <?php }?>
                </td>
                <td>
                    <?php if ($tournament->getTournamentOwnerId() === $userLogedin->getId()) { ?>
                        <?php if ($tournament->getIsActive() === 1) { ?>
                        <form action="team_manager/index.php" method="POST">
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>" /> 
                            <input type="hidden" name="controllerRequest" value="delete_tournament" /> 
                            <input type="submit" value="Delete">
                        </form>
                        <?php } else {?>
                            <form action="team_manager/index.php" method="POST">
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>" /> 
                            <input type="hidden" name="controllerRequest" value="activate_tournament" /> 
                            <input type="submit" value="Activate">
                        </form>
                        <?php }?>
                    <?php }?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php } ?>

<?php require_once '../view/footer.php'; ?>