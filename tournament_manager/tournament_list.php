<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" type="text/css" href="styles/table.css">
<link rel="stylesheet" type="text/css" href="styles/tournament_list.css">


<h1>Tournament List</h1>


<form action="user_manager/index.php" method="POST">
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


<div class="tournament-container">
    <?php foreach ($tournaments as $tournament) : ?>
        <div class="tournament-tag" id="<?php echo $tournament->getId();?>">
            <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId();?>" />
            <h2><?php echo $tournament->getTournamentName(); ?></h2>
            <h3><?php echo $tournament->getTournamentOrganizerName(); ?></h3>
            <div class="dates">
                <div class="dateStart">
                    <label>Start Date: </label><span><?php echo $tournament->getTournamentDate(); ?></span>
                </div>
                <div class="dateRegister">
                    <label>Registration Deadline: </label><span><?php echo $tournament->getTournamentRegistrationDeadline(); ?></span>
                </div>
            </div>

        </div>   
    <?php endforeach; ?>
</div>



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
