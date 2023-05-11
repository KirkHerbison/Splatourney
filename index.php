<?php 
require_once 'model/User.php';
require_once 'model/Tournament.php';
require_once('model/database.php');
require_once('model/home_db.php');
session_start();

if(isset($_SESSION['userLogedin'])){  
    $userLogedin = $_SESSION['userLogedin'];
}
else{
    $userLogedin = new User(null, null, '', '', '', '', '', '', '', '', '', '', false, false);
}

$tournaments = get_upcoming();

require_once 'view/header.php';

?>
<link rel="stylesheet" type="text/css" href="styles/home.css">
<link rel="stylesheet" type="text/css" href="styles/tournament_list.css">




 <h1>Splatourney</h1>
 <p>Splatourney is being designed to offer a Splatoon exclusive experience for tournaments.
     Many features in place already increase the ease of managing and participating in tournaments
     compared to other websites. There are also many features in the future that will be added in
     the future to make the experience the preferred form of competitive Splatoon tournaments.
 </p>
 <br>
 <p>This is an early version of Splatourney. I am looking to build a team of developers 
    and graphics designers who would be interested in helping make this project a reality.
    If you have skills in graphics design, CSS, PHP, SQL, Javascript, or any relevant field
    please consider offering your help with this project. Contact *******#0001 on Discord if you are interested.
 </p>

 <h1>Upcoming Tournmanets</h1>
 
 <div class="tournament-container">
    <?php foreach ($tournaments as $tournament) : ?>
        <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>" />
        <div class="tournament-tag" id="<?php echo $tournament->getId(); ?>" <?php if ($tournament->getTournamentBannerLink() != '') {
        echo "style=\"background-image: url('images/tournament_images/" . $tournament->getTournamentBannerLink() . "')\"";
    } ?> >
            <div class="tournament-details">
                <div class='details-top'> 

                    <h2><?php echo $tournament->getTournamentName(); ?></h2>
                    <h3><?php echo $tournament->getTournamentOrganizerName(); ?></h3>
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
 
<?php require_once 'view/footer.php'; ?>