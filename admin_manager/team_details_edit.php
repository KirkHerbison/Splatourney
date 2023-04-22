<?php require_once '../view/header.php'; ?> 

<h1><?php echo $team->getTeamName(); ?>'s Details</h1>
<br>
<form action="admin_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="team_update" />
    <input type="hidden" name="teamId" value="<?php echo $team->getId(); ?>"/>
    <input type="hidden" name="teamImageLink" value="<?php echo $team->getTeamImageLink(); ?>"/>
    <div>
        <label>Name:</label>
        <input type='text' name="teamName" value="<?php echo $team->getTeamName(); ?>">
    </div>
    <br>
    <div>
        <label>Team Image:</label>
        <img style=" max-height: 100px; max-width: 100px" src="images/team_images/<?php echo $team->getTeamImageLink(); ?>" alt="<?php echo $team->getTeamName(); ?> team image" />
    </div>
    <div>
        <label>Remove Team Image:</label>
        <input type='checkbox' name="removeTeamImage">
    </div>
    <br>
    <div class="button">
        <input type='submit' value='Update'>
    </div>
</form>

<?php require_once '../view/footer.php'; ?>