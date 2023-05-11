<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" type="text/css" href="styles/match.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@800&display=swap');
</style>
<input type="hidden" id="matchId" name="matchId" value="<?php echo $bracketMatch->getId(); ?>">
<input type="hidden" id="userId" name="userId" value="<?php echo $userLogedin->getId(); ?>">
<?php if($bracketMatch->getTeamOneId() != null && $bracketMatch->getTeamTwoId() != null){ ?>
<h1 id="vs">
    <?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamName(); ?> 
    VS 
    <?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamName(); ?>
</h1>
<?php } ?>

<form action="bracket_manager/index.php" method="POST" style="display: flex;">
    <input type="hidden" name="controllerRequest" value="bracket" /> 
    <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
    
    <div class="button">
        <input  type="submit" value="Return To Bracket">
    </div>
</form>

<div id="match"> 

    <div class="scoreTeamOne">
        <?php if($bracketMatch->getTeamOneId() != null){ ?>
        <h2 class="team"><?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamName(); ?></h2>
        <img style=" max-height: 200px; max-width: 200px" src="images/team_images/<?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamImageLink(); ?>" alt="<?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamName(); ?> team image" />
        <hr>
        <p class="win">wins: </p>
        <h1 class="scoreDisplay"><span id="teamOneScore"><?php echo $bracketMatch->getTeamOneWins(); ?></span></h1>
        <?php if($bracketMatch->getTeamOneWins() < $wins_needed_to_win && $bracketMatch->getTeamTwoWins() < $wins_needed_to_win && (get_team_by_id($bracketMatch->getTeamOneId())->getCaptainUserId() == $userLogedin->getId() || get_tournament_by_id($bracketMatch->getTournamentId())->getTournamentOwnerId() == $userLogedin->getId())){?>
            <button id="teamOneWin">Add Win</button>
        <?php } ?>
        <hr>
        <div class="contactInfo">
            <div class="contactDiv">
                <p class="constactLabel">Friend Code:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamOneId())->getCaptainUserId())->getSwitchFriendCode(); ?></p>
            </div>
            <div class="contactDiv">
                <p class="constactLabel">Discord:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamOneId())->getCaptainUserId())->getDiscordUsername(); ?> </p>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <div class="middle-div"> 
        
        <div class="mapList">
            <?php $gameNumber = 1; ?>
            <?php foreach ($games as $game) : ?>
                <?php if($game->getMapId() > 0) { ?>
                <div class="game">
                    <p>game <?php echo $gameNumber; ?></p>
                    <p><?php echo get_map_by_id($game->getMapId())->getDescription(); ?></p>
                    <img style="max-width: 200px;" src="<?php echo get_map_image_link_by_id($game->getMapId()); ?>" alt="<?php echo get_map_by_id($game->getMapId())->getDescription(); ?>"/>
                    <img class ="mode" style="max-width: 200px;" src="<?php echo get_mode_image_link_by_id($game->getModeId()); ?>" alt="<?php echo get_mode_by_id($game->getModeId())->getDescription(); ?>"/>

                </div>
                <?php } ?>
                <?php $gameNumber++; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="chat-box">
            <div id='chat' class="chat">

                <div class="chat-container active" id='cont1'>        
                    <?php foreach ($messages as $message) : ?> 
                        <div class="<?php echo ($message->getUserId() === $userLogedin->getID()) ? "bubble bubble-alt" : "bubble"; ?>">
                            <p><?php echo $message->getMessage(); ?></p>
                        </div>
                    <span class="<?php echo ($message->getUserId() === $userLogedin->getID()) ? "datestamp  dt-alt" : "datestamp"; ?>"><?php echo get_user_by_id($message->getUserId())->getUsername(); ?> - <?php echo date("H:i:s", strtotime($message->getDateSent())); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="chat-control">
                <input class="chat-input" id="message" type="text" placeholder="enter your message" />
            </div>
        </div>
        
    </div>      
    <div class="scoreTeamTwo">
        <?php if($bracketMatch->getTeamTwoId() != null){ ?>
        <h2 class="team"><?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamName(); ?></h2>
        <img style=" max-height: 200px; max-width: 200px" src="images/team_images/<?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamImageLink(); ?>" alt="<?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamName(); ?> team image" />
        <hr>
        <p class="win">wins: </p>
        <h1 class="scoreDisplay"><span id="teamTwoScore"><?php echo $bracketMatch->getTeamTwoWins(); ?></span></h1>
        <?php if($bracketMatch->getTeamOneWins() < $wins_needed_to_win && $bracketMatch->getTeamTwoWins() < $wins_needed_to_win  && (get_team_by_id($bracketMatch->getTeamTwoId())->getCaptainUserId() == $userLogedin->getId() || get_tournament_by_id($bracketMatch->getTournamentId())->getTournamentOwnerId() == $userLogedin->getId()) ){?>
            <button id="teamTwoWin">Add Win</button>
        <?php } ?>
        <hr>
        <div class="contactInfo">
            <div class="contactDiv">
                <p class="constactLabel">Friend Code:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamTwoId())->getCaptainUserId())->getSwitchFriendCode(); ?></p>
            </div>
            <div class="contactDiv">
                <p class="constactLabel">Discord:</p>
                <p class="constactDetail"><?php echo get_user_by_id(get_team_by_id($bracketMatch->getTeamTwoId())->getCaptainUserId())->getDiscordUsername(); ?> </p>
            </div>
        </div>   
        <?php } ?>
    </div>
</div>

<script src="js/chatbox.js"></script>
<script src="js/chat_timer.js"></script>
<script src="js/update_score.js"></script>
<?php require_once '../view/footer.php'; die();?>
