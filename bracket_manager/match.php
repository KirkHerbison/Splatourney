<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" type="text/css" href="styles/match.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/update_score.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@800&display=swap');
</style>



<input type="hidden" id="matchId" name="matchId" value="<?php echo $bracketMatch->getId(); ?>">
<h1 id="vs"><?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamName();?> VS <?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamName();?></h1>
<hr>
<div id="match"> 


    <div class="Score">
        <h2 class="team"><?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamName();?></h2>
        <hr>
        
        
        
        <p class="win">wins: </p>
        <h1 class="scoreDisplay"><?php echo $bracketMatch->getTeamOneWins();?></h1>
        <button id="teamOneWin">Add Win</button>
        <hr>
        <div class="contactInfo">
            <div class="contactDiv">
                <p class="constactLabel">Friend Code:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamOneId())->getCaptainUserId())->getSwitchFriendCode()    ;?></p>
            </div>
            <div class="contactDiv">
                <p class="constactLabel">Discord:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamOneId())->getCaptainUserId())->getDiscordUsername(); ?> </p>
            </div>
        </div>
        
        
    </div>

    <div class="mapList">

                <?php $gameNumber = 1; ?>
                <?php foreach ($games as $game) : ?> 
                <div class="game">

                    <p>game <?php echo $gameNumber; ?></p>
                    <p><?php echo get_map_by_id($game->getMapId())->getDescription(); ?></p>
                    <img style="max-width: 200px;" src="<?php echo get_map_image_link_by_id($game->getMapId()); ?>" alt="<?php echo get_map_by_id($game->getMapId())->getDescription(); ?>"/>
                    <img class ="mode" style="max-width: 200px;" src="<?php echo get_mode_image_link_by_id($game->getModeId()); ?>" alt="<?php echo get_mode_by_id($game->getModeId())->getDescription(); ?>"/>

                </div>
                <?php $gameNumber++; ?>
                <?php endforeach; ?>


    </div>

    <div class="Score">
        <h2 class="team"><?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamName();?></h2>
        <hr>
        
        
        
        <p class="win">wins: </p>
        <h1 class="scoreDisplay"><?php echo $bracketMatch->getTeamTwoWins();?></h1>
        <button id="teamTwoWin">Add Win</button>
        <hr>
        <div class="contactInfo">
            <div class="contactDiv">
                <p class="constactLabel">Friend Code:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamTwoId())->getCaptainUserId())->getSwitchFriendCode()    ;?></p>
            </div>
            <div class="contactDiv">
                <p class="constactLabel">Discord:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamTwoId())->getCaptainUserId())->getDiscordUsername(); ?> </p>
            </div>
        </div>   
    </div>
</div>

<?php require_once '../view/footer.php'; ?>