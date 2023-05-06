<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" href="styles/tournament_signup.css">

<form action="tournament_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="signup_confirmation" />
    <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>" /> 

    <div class="center">
        <div class='div_form'>
            <span style='color: red'><?php echo $error_message ?></span>
            <br>
            <div class="txt_field">
                <select name="team_id" id="team_id">
                    <option value="0">Select A Team</option> 
                    <?php foreach ($teams as $team) : ?>    
                        <option value="<?php echo $team->getId(); ?>">
                            <?php echo $team->getTeamName(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Select Team:</label>
            </div>
                <button id="loginButton" type="submit" >Register</button>
        </div>
    </div>
</form>
<?php require_once '../view/footer.php'; ?>