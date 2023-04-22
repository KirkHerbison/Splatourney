<?php require_once '../view/header.php'; ?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!--for image upload -->
<link rel="stylesheet" type="text/css" href="styles/image_upload_1.css"><!-- for image upload -->
<link rel="stylesheet" href="styles/tournament_register.css"/>








<div class="container">
    <div class="title">Create Tournament</div>
    <span style='color: red'><?php echo $error_message ?></span>
    <div class="content">
        <form action="tournament_manager/index.php" method="post"  enctype="multipart/form-data">  
            <input type="hidden" name="controllerRequest" value="tournament_register_confirmation" /> 
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Tournament Name<span style="color: red;">*</span></span>
                    <input type="text" name="tournamentName" placeholder="tournament name" required>
                </div>
                <div class="input-box">
                    <span class="details">Organization Name<span style="color: red;">*</span></span>
                    <input type="text" name="tournamentOrganizerName" placeholder="organization name" required>
                </div>
                <div class="input-box">
                    <span class="details">Start Date Time</span>
                    <input type='datetime-local' name="tournamentDateTime" required>
                </div>
                <div class="input-box">
                    <span class="details">Registration Deadline<span style="color: red;">*</span></span>
                    <input type='datetime-local' name="tournamentDeadline" required>
                </div>
            </div>
            <div class="input-box">
              <span class="details">Tournament Banner</span>
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
                    <textarea name="tournamentAbout" maxlength="5000" rows="4" cols="70"></textarea>
                </div>
                <div class="input-box">
                    <span class="details">Prizes</span>
                    <textarea name="tournamentPrizes" maxlength="5000" rows="4" cols="70"></textarea>
                </div>
                <div class="input-box">
                    <span class="details">Contact</span>
                    <textarea name="tournamentContact" maxlength="5000" rows="4" cols="70"></textarea>
                </div>
                <div class="input-box">
                    <span class="details">Rules</span>
                    <textarea name="tournamentRules" maxlength="5000" rows="4" cols="70"></textarea>
                </div>
                <div class="button">
                    <input type='submit' value='Create'>           
                </div>  
        </form>
    </div>
</div>


<script src="js/image_upload.js"></script>
<?php require_once '../view/footer.php'; ?>
