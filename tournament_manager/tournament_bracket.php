<?php require_once '../view/header.php'; ?>
<h1>Tournament Bracket</h1>
<?php foreach ($roundArray as $round) : ?>
    <h2>Round <?php echo $round->getRoundNumber();?></h2>
        <?php foreach ($round->getMatches() as $match) : ?>
            <p>Match #<?php echo $match->getMatchNumber();?></p>
            <p> <?php if ($match->getWinnerTeamId() == $match->getTeamOneId()) { ?><b><?php }?><?php echo get_team_by_id($match->getTeamOneId())->getTeamName();?><?php if ($match->getWinnerTeamId() == $match->getTeamOneId()) { ?></b><?php }?> VS <?php if ($match->getWinnerTeamId() == $match->getTeamTwoId()) { ?><b><?php }?><?php echo  get_team_by_id($match->getTeamTwoId())->getTeamName() ;?><?php if ($match->getWinnerTeamId() == $match->getTeamTwoId()) { ?></b><?php }?></p>
        <?php endforeach; ?>
    <hr>
<?php endforeach; ?>
<?php require_once '../view/footer.php'; ?>
