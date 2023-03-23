<?php require_once '../view/header.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<input type="hidden" id="matchId" name="matchId" value="<?php echo $bracketMatch->getId(); ?>">
<h1>Tournament Match</h1>
<div class="mapList">

            <?php $gameNumber = 1; ?>
            <?php foreach ($games as $game) : ?> 
            <div class="game">
                
                <p>game <?php echo $gameNumber; ?></p>
                <img style="max-width: 200px;" src="<?php echo get_map_image_link_by_id($game->getMapId()); ?>" alt="<?php echo get_map_by_id($game->getMapId())->getDescription(); ?>"/>

            </div>
            <?php $gameNumber++; ?>
            <?php endforeach; ?>

    
</div>
<div class="Score">
    <button id="teamOneWin">Team One Win</button>
    <p id="teamOneScore">team 1 wins: <?php echo $bracketMatch->getTeamOneWins();?></p>
</div>

<div class="Score">
    <button id="teamTwoWin">Team Two Win</button>
    <p id="teamTwoScore">team 2 wins: <?php echo $bracketMatch->getTeamTwoWins();?></p>
</div>



<p>team 1</p>
<p><?php echo get_team_by_id($bracketMatch->getTeamOneId())->getTeamName();?></p>
<p>team 2</p>
<p><?php echo get_team_by_id($bracketMatch->getTeamTwoId())->getTeamName();?></p>
<script src="js/update_score.js"></script>
<?php require_once '../view/footer.php'; ?>