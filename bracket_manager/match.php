<?php require_once '../view/header.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<input type="hidden" id="matchId" name="matchId" value="<?php echo $match->getId(); ?>">
<h1>Tournament Match</h1>
<div id="Score">
    <button id="teamOneWin">Team One Win</button>
    <p>team 1 wins: <?php echo $match->getTeamOneWins();?></p>
</div>
<p>team 1</p>
<p><?php echo get_team_by_id($match->getTeamOneId())->getTeamName();?></p>
<p>team 2</p>
<p><?php echo get_team_by_id($match->getTeamTwoId())->getTeamName();?></p>
<script src="js/update_score.js"></script>
<?php require_once '../view/footer.php'; ?>