<?php require_once '../view/header.php'; ?>

<link rel="stylesheet" type="text/css" href="styles/team_list.css">
<form class='search-form' action="team_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="team_search_by_name" /> 
        <label>Search by team name:</label>
        <input class="team-name-input" type="text" name="team_search">
        <div class="search-button">
            <input  type="submit" value="Search">
        </div>
    <br>
</form>

<div class="team-container">
    <?php foreach ($teams as $team) : ?>
    <div class="team-tag" id="<?php echo $team->getId();?>">
        <div class="team-details">
            <img src="<?php echo $team->getTeamImageLink(); ?>" alt="<?php echo $team->getTeamName(); ?> Image"/>
            
            <div class="team-info">
                <span class="team-name"><?php echo $team->getTeamName(); ?></span>
                <span class="team-captain">Captain: <?php echo $team->getTeamCaptainName(); ?></span>
            </div>
            <div class="button-group">
                <form action="team_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="team_profile" />
                    <input type="hidden" name="teamId" value="<?php echo $team->getId(); ?>">
                    <input type="submit" value="Details">
                </form>
                <form action="team_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="team_results" /> 
                    <input type="hidden" name="teamId" value="<?php echo $team->getId(); ?>">
                    <input class="button-regiser" type="submit" value="Results">
                </form>
            </div>    
            </div>
        </div>             
    <?php endforeach; ?>
</div>

<?php require_once '../view/footer.php'; ?>