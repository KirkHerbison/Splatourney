<?php require_once '../view/header.php'; ?> 

<h1>Create Tournament</h1>
<span style='color: red'><?php echo $error_message ?></span>
<form action="tournament_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="tournament_register_confirmation" /> 
    <br>
    <div>
        <p>Organization Name: </p>
        <input type="text" name="tournamentOrganizerName" value="My Organization">
    </div>
    <br>
    <div>
        <p>Tournament Type: </p>
        <select name="tournamentType" id="tournamentType">
            <?php foreach ($tournamnetTypes as $type) { ?>
                    <option value="<?php echo $type->getId(); ?>" ><?php echo $type->getDescription(); ?></option>
            <?php }?>        
        </select>
    </div>
    <br>
    <div>
        <p>Tournament Banner: 1290 x 600</p>
        <input type="file" name="tournamentBanner">
    </div>
    <br>
    <div>
        <p>Tournament Name: </p>
        <input type="text" name="tournamentName" value="My Tournament Name">
    </div>
    <br>
    <div>
        <p>Tournament Date Time: </p>
        <input type='datetime-local' name="tournamentDateTime">
    </div>
    <br>
    <div>
        <p>Tournament Registration Deadline: </p>
        <input type='datetime-local' name="tournamentDeadline">
    </div>
    <br>
    <div>
        <p>Tournament About: </p>
        <textarea name="tournamentAbout" maxlength="5000" rows="4" cols="70">About tournament</textarea>
    </div>
    <br>
    <div>
        <p>Prizes: </p>
        <textarea name="tournamentPrizes" maxlength="5000" rows="4" cols="70">Prizes</textarea>
    </div>
    <br>
    <div>
        <p>Contact: </p>
        <textarea name="tournamentContact" maxlength="5000" rows="4" cols="70">Contact</textarea>
    </div>
    <br>
    <div>
        <p>Rules: </p>
        <textarea name="tournamentRules" maxlength="5000" rows="4" cols="70">Rules</textarea>
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='Create Tournament'>
    </div>
    <br>
</form>

<?php require_once '../view/footer.php'; ?>