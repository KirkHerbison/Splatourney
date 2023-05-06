<?php require_once '../view/header.php'; ?> 

<link rel="stylesheet" type="text/css" href="styles/table.css">
<link rel="stylesheet" type="text/css" href="styles/results.css">

<?php if($tournamentsJoined != null){ ?>
    <h1>Joined Tournaments</h1>
    <table class="content-table">
        <thead>
            <tr>
                <th>Tournament Name</th>
                <th>Details</th>
                <th>Bracket</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tournamentsJoined as $tournament) : ?>
            <?php if ($tournament->getIsActive() === 1) { ?>
                <tr>
                    <td><?php echo $tournament->getTournamentName(); ?></td>
                    <td>
                        <form action="tournament_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="details" />
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>">
                            <input type="submit" value="Details">
                        </form>
                    </td>
                    <td>
                        <form action="bracket_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="bracket" /> 
                            <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                            <input class="button-regiser" type="submit" value="Bracket">
                        </form>
                    </td>
                </tr>
            <?php }?>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>  

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
                    <form action="bracket_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="bracket" /> 
                        <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                        <input class="button-regiser" type="submit" value="Bracket">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?> 

<?php require_once '../view/footer.php'; ?>