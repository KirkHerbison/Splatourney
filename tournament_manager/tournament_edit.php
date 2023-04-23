
<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="js/hrefLinks.js"></script>
<link rel="stylesheet" type="text/css" href="styles/image_upload_1.css"><!-- for image upload -->
<link rel="stylesheet" type="text/css" href="styles/tournament_edit.css">
<script>
    $(function () {
        $("#tabs").tabs();
        console.log("tabs is loading");
    });
</script>



<div id="tabs">
    <ul>
        <li><a href="#tabs-1" >Basic Info</a></li>
        <li><a href="#tabs-2" >Bracket</a></li>
        <li><a href="#tabs-3" >Map List</a></li>
    </ul>


    <div id="tabs-1">    
        <div class="container">
            <div class="title">Create Tournament</div>
            <span style='color: red'><?php echo $error_message ?></span>
            <div class="content">
                <form action="tournament_manager/index.php" method="post"  enctype="multipart/form-data">  
                    <input type="hidden" name="controllerRequest" value="tournament_update_confirmation" /> 
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Tournament Name<span style="color: red;">*</span></span>
                            <input type="text" name="tournamentName" placeholder="tournament name"  value="<?php echo $tournament->getTournamentName(); ?>" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Organization Name<span style="color: red;">*</span></span>
                            <input type="text" name="tournamentOrganizerName" placeholder="organization name"  value="<?php echo $tournament->getTournamentOrganizerName(); ?>" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Start Date Time</span>
                            <input type='datetime-local' name="tournamentDateTime" value="<?php echo $tournament->getTournamentDate(); ?>" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Registration Deadline<span style="color: red;">*</span></span>
                            <input type='datetime-local' name="tournamentDeadline" value="<?php echo $tournament->getTournamentRegistrationDeadline(); ?>" required>
                        </div>
                    </div>
                    <div class="input-box">
                      <span class="details">New Tournament Banner</span>
                      <div class="drag-image">
                        <div class="wrapper">
                          <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                          <h6>Drag & Drop File Here</h6>
                          <p>1290 x 600</p>
                          <span>OR</span>
                          <button type="button">Browse File</button>
                          <input type="file" name="image" accept = "image/*" hidden>
                        </div>
                      </div>
                      <div class="display-image" style="display: none;"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">About</span>
                        <textarea name="tournamentAbout" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentAbout(); ?></textarea>
                    </div>
                    <div class="input-box">
                        <span class="details">Prizes</span>
                        <textarea name="tournamentPrizes" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentPrizes(); ?></textarea>
                    </div>
                    <div class="input-box">
                        <span class="details">Contact</span>
                        <textarea name="tournamentContact" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentContact(); ?></textarea>
                    </div>
                    <div class="input-box">
                        <span class="details">Rules</span>
                        <textarea name="tournamentRules" maxlength="5000" rows="4" cols="70"><?php echo $tournament->getTournamentRules(); ?></textarea>
                    </div>
                    <div class="button">
                        <input type='submit' value='Save Changes'>           
                    </div>  
                </form>
            </div>
        </div>       
    </div>
    
    
    <div id="tabs-2">
        <h1>Tournament Brackets</h1>
        <span style='color: red'><?php //echo $error_message_brcket ?></span>
        <form action="tournament_manager/index.php" method="POST">
            <input type="hidden" name="tournamentId" value="<?php echo $tournament->getId(); ?>" />
            <input type="hidden" name="controllerRequest" value="insert_bracket" /> 
            <div>
                <label>Number of Rounds</label>
                <select name="rounds" id="rounds">
                    <option value="1" >1 Round | 2 teams</option>
                    <option value="2" >2 Rounds | 3-4 teams</option>  
                    <option value="3" >3 Rounds | 5-8 teams</option>  
                    <option value="4" >4 Rounds | 9-16 teams</option>  
                    <option value="5" >5 Rounds | 17-32 teams</option>  
                    <option value="6" >6 Rounds | 33-64 teams</option>  
                    <option value="7" >7 Rounds | 65-128 teams</option>  
                    <option value="8" >8 Rounds | 129-256 teams</option>  
                    <option value="9" >9 Rounds | 257-512 teams</option>  
                    <option value="10" >10 Rounds | 513-1024 teams</option>  
                    <option value="11" >11 Rounds | 1025-2048 teams</option>  
                </select>
            </div>
            <div>
                <label>Bracket name</label>
                <input type="text" name="tournamentBracketName">
            </div>
            <input type="submit" value="Add">
        </form> 
    </div>
    
    
    <div id="tabs-3">
        <div class="maplist-container">
            <?php foreach ($mapLists as $mapList) : ?> 
                <div class="round-container">
                    <div class="round" id="round<?php echo $mapList->getRound();?>">
                        <h1>Round <?php echo $mapList->getRound(); ?></h1>
                        <?php $games = get_match_games_by_id($mapList->getId()); ?>
                        <?php foreach ($games as $game) : ?> 
                        <div class="game" id="game<?php echo $game->getGameNumber();?>">      
                                <label>game <?php echo $game->getGameNumber(); ?></label>
                                <div class="mapPicker">
                                    <label>Map</label>
                                    <select name="map" id="map" class="map-select">
                                        <option value="NONE">NONE</option> 
                                        <?php foreach ($maps as $map) : ?>    
                                            <option <?php if($map->getId() == $game->getMapId()){ echo 'selected'; }?> value="<?php echo $map->getId();?>"><?php echo $map->getDescription() ;?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="modePicker" >    
                                <label>Mode</label>
                                    <select name="mode" id="mode" class="mode-select">
                                        <option value="NONE">NONE</option>    
                                        <?php foreach ($modes as $mode) : ?> 
                                            <option <?php if($mode->getId() == $game->getModeId()){ echo 'selected'; }?> value="<?php echo $mode->getId();?>"><?php echo $mode->getDescription() ;?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>     
    </div>
</div>

<script src="js/maplist.js"></script>
<script src="js/image_upload.js"></script>
<?php require_once '../view/footer.php'; ?>