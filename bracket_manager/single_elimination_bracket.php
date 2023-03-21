<?php require_once '../view/header.php'; ?>
<h1>Tournament Bracket</h1>
<?php foreach ($roundArray as $round) : ?>
    <h2>Round <?php echo $round->getRoundNumber();?></h2>
        <?php foreach ($round->getMatches() as $match) : ?>
            <form class="matchForm" method="POST" action="bracket_manager/index.php">
                <input type="hidden" name="controllerRequest" value="match" />
                <input type="hidden" name="matchId" value="<?php echo $match->getId(); ?>">
                <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                <p>Match #<?php echo $match->getMatchNumber();?></p>
                <p class="match">
                    <?php if ($match->getWinnerTeamId() == $match->getTeamOneId()) { ?><b><?php }?><?php echo get_team_by_id($match->getTeamOneId())->getTeamName();?><?php if ($match->getWinnerTeamId() == $match->getTeamOneId()) { ?></b><?php }?>
                    VS
                    <?php if ($match->getWinnerTeamId() == $match->getTeamTwoId()) { ?><b><?php }?><?php echo  get_team_by_id($match->getTeamTwoId())->getTeamName() ;?><?php if ($match->getWinnerTeamId() == $match->getTeamTwoId()) { ?></b><?php }?>
                </p>
            </form>
        <?php endforeach; ?>
    <hr>
<?php endforeach; ?>
<script src="js/go_to_match.js"></script>
<?php require_once '../view/footer.php'; ?>