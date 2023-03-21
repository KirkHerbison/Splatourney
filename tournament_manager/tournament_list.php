<?php require_once '../view/header.php'; ?>
<h1>Tournament List</h1>
<form action="team_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="tournament_search_by_name" /> 
    <br>
    <div>
        <p>Search by tournament name:</p>
        <input type="text" name="tournament_search">
    </div>
    <br>
    <div>
        <p></p><input type="submit" value="Search">
    </div>
    <br>
</form>

<table>
    <tr>
        <th>Name</th>
        <th>date</th>
        <th>detail</th>
        <th>edit</th>
    </tr>
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
            <?php if($tournament->getTournamentOwnerId() == $userLogedin->getId()){ ?>
            <td>
                <form action="team_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="tournament_edit" /> 
                    <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                    <input type="submit" value="Edit">
                </form>
            </td>
            <?php }?>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>
