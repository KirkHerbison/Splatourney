<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" type="text/css" href="styles/tournament_edit.css">
<div class="container">
    <div class="title"><?php echo $tournament->getTournamentName(); ?></div>
    <span style='color: red'><?php echo $error_message ?></span>
    <div class="content">
        <div class="user-details">
            <div class="input-box">
                <span class="details">Organization Name</span>
                <input type="text" value="<?php echo $tournament->getTournamentOrganizerName(); ?>" disabled>
            </div>
            <div class="input-box">
                <span class="details">Start Date Time</span>
                <input type='datetime-local'  value="<?php echo $tournament->getTournamentDate(); ?>" disabled>
            </div>
            <div class="input-box">
                <span class="details">Registration Deadline</span>
                <input type='datetime-local' value="<?php echo $tournament->getTournamentRegistrationDeadline(); ?>" disabled>
            </div>
        </div>
        <div class="input-box">
            <span class="details">About</span>
            <textarea rows="4" cols="70" disabled><?php echo $tournament->getTournamentAbout(); ?></textarea>
        </div>
        <div class="input-box">
            <span class="details">Prizes</span>
            <textarea rows="4" cols="70" disabled><?php echo $tournament->getTournamentPrizes(); ?></textarea>
        </div>
        <div class="input-box">
            <span class="details">Contact</span>
            <textarea rows="4" cols="70" disabled><?php echo $tournament->getTournamentContact(); ?></textarea>
        </div>
        <div class="input-box">
            <span class="details">Rules</span>
            <textarea rows="4" cols="70" disabled><?php echo $tournament->getTournamentRules(); ?></textarea>
        </div>
        
        <form action="tournament_manager/index.php" method="POST">
            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>" />
            <input type="hidden" name="controllerRequest" value="tournament_signup" /> 
            <div class="button">
                <input type="submit" value="Register">
            </div>
        </form> 
        
    </div>
</div>       

<?php require_once '../view/footer.php'; ?>
