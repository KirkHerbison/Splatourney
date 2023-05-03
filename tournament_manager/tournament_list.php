<?php require_once '../view/header.php'; ?>

<link rel="stylesheet" type="text/css" href="styles/tournament_list.css">


<form class='search-form' action="tournament_manager/index.php" method="POST">
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
        <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>" />
        <div class="tournament-tag" id="<?php echo $tournament->getId(); ?>" <?php if ($tournament->getTournamentBannerLink() != '') {
        echo "style=\"background-image: url('images/tournament_images/" . $tournament->getTournamentBannerLink() . "')\"";
    } ?> >
            <div class="tournament-details">
                <div class='details-top'> 

                    <h2><?php echo $tournament->getTournamentName(); ?></h2>
                </div>
                <div class="details-bottom">
                    <div class='dates'>
                        <div class="dateStart">
                            <?php 
                                $date_str_start = $tournament->getTournamentDate();
                                $date_start = new DateTime($date_str_start);
                                $formated_date_start = $date_start->format('D M d g:i A');
                            ?>             
                            <label>Start Date: </label><span><?php echo $formated_date_start; ?></span>
                        </div>
                        <div class="dateRegister">
                             <?php 
                                $date_str_end = $tournament->getTournamentRegistrationDeadline();
                                $date_end= new DateTime($date_str_end);
                                $formated_date_end = $date_end->format('D M d g:i A');
                            ?>
                            <label>Registration Deadline: </label><span><?php echo $formated_date_end; ?></span>
                        </div>
                    </div>
                    <div class="button-group">
                        <form action="tournament_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="details" />
                            <input type="hidden" name="tournament_id" value="<?php echo $tournament->getId(); ?>">
                            <input type="submit" value="Details">
                        </form>
                        <form action="bracket_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="bracket" /> 
                            <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>">
                            <input class="button-regiser" type="submit" value="Bracket">
                        </form>
                    </div>



                </div>
            </div>            
        </div>   
<?php endforeach; ?>
</div>

<?php require_once '../view/footer.php'; ?>
