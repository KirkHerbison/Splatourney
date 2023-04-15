<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" type="text/css" href="styles/tournament_list.css">
<form class='search-form' action="user_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="tournament_search_by_name" /> 
        <label>Search by tournament name:</label>
        <input class="tournament-name-input" type="text" name="tournament_search">
        <div class="search-button">
            <input  type="submit" value="Search">
        </div>
    <br>
</form>


<div class="tournament-container">
    <?php foreach ($tournaments as $tournament) : ?>
    <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId();?>" />
    <div class="tournament-tag" id="<?php echo $tournament->getId();?>" <?php if($tournament->getTournamentBannerLink() != ''){ echo  "style=\"background-image: url('" . $tournament->getTournamentBannerLink()."')\""; }?> >
        <div class="tournament-details">
            <div class='details-top'> 
            
            <h2><?php echo $tournament->getTournamentName(); ?></h2>
            <h3><?php echo $tournament->getTournamentOrganizerName(); ?></h3>
            </div>
            <div class="details-bottom">
                <div class='dates'>
                <div class="dateStart">
                    <label>Start Date: </label><span><?php echo $tournament->getTournamentDate(); ?></span>
                </div>
                <div class="dateRegister">
                    <label>Registration Deadline: </label><span><?php echo $tournament->getTournamentRegistrationDeadline(); ?></span>
                </div>
                </div>
                <div class="button-group">
                    <form action="bracket_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="bracket" />
                    <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                    <input type="submit" value="Details">
                </form>
                                    <form action="team_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="to_tournament_registration" /> 
                    <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                    <input class="button-regiser" type="submit" value="Register">
                </form>
                </div>
                
                
                
            </div>
        </div>            
        </div>   
    <?php endforeach; ?>
</div>


<?php require_once '../view/footer.php'; ?>
