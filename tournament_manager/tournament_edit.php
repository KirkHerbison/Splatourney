<?php require_once '../view/header.php'; ?> 

<h1>Edit Tournament</h1>
<span style='color: red'><?php echo $error_message ?></span>
<form action="tournament_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="tournament_edit" /> 
    <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>" />
    <br>
    <div>
        <p>Organization Name: </p>
        <input type="text" name="tournamentOrganizerName" value="<?php echo $tournament->getTournamentOrganizerName(); ?>">
    </div>
    <br>
    <div>
        <p>Tournament Type: </p>
        <select name="tournamentType" id="tournamentType">
            <?php foreach ($tournamnetTypes as $type) { ?>
                    <option value="<?php echo $type->getId(); ?>" <?php if($type->getId() == $tournament->getTournamentTypeId()){echo "selected";} ?>><?php echo $type->getDescription(); ?></option>
            <?php }?>        
        </select>
    </div>
    <br>
    <div>
        <p>Tournament Banner: </p>
        <input type="text" name="<?php echo $tournament->getTournamentBannerLink(); ?>">
    </div>
    <br>
    <div>
        <p>Tournament Name: </p>
        <input type="text" name="tournamentName" value="<?php echo $tournament->getTournamentName(); ?>">
    </div>
    <br>
    <div>
        <p>Tournament Date Time: </p>
        <input type='datetime-local' name="tournamentDateTime" value="<?php echo $tournament->getTournamentDate(); ?>">
    </div>
    <br>
    <div>
        <p>Tournament Registration Deadline: </p>
        <input type='datetime-local' value="<?php echo $tournament->getTournamentRegistrationDeadline(); ?>" name='tournamentDeadline'>
    </div>
    <br>
    <div>
        <p>Tournament About: </p>
        <textarea name="tournamentAbout" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentAbout(); ?></textarea>
    </div>
    <br>
    <div>
        <p>Prizes: </p>
        <textarea name="tournamentPrizes" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentPrizes(); ?></textarea>
    </div>
    <br>
    <div>
        <p>Contact: </p>
        <textarea name="tournamentContact" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentContact(); ?></textarea>
    </div>
    <br>
    <div>
        <p>Rules: </p>
        <textarea name="tournamentRules" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentRules(); ?></textarea>
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='Edit Tournament'>
    </div>
    <br>
</form>

<?php require_once '../view/footer.php'; ?>