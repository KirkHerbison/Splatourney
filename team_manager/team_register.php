<?php require_once '../view/header.php'; ?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!--for image upload -->
<link rel="stylesheet" type="text/css" href="styles/image_upload.css"><!-- for image upload -->
<link rel="stylesheet" type="text/css" href="styles/team_register.css"/>

<script src="js/jquery.slicknav.min.js"></script>

<div class="container">


    <div class="title">Create Team</div>

    <span style='color: red'><?php echo $error_message ?></span>
    <div class="content">
        <form action="team_manager/index.php" method="post" enctype="multipart/form-data">
            <?php if($team_id > 0){ ?>
                <input type="hidden" name="controllerRequest" value="team_update_confirmation" />
                <input type="hidden" name="team_id" value="<?php echo $team_id ?>" /> 
            <?php } else{  ?>
                <input type="hidden" name="controllerRequest" value="team_register_confirmation" /> 
            <?php } ?>
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Team Name <span style="color: red;">*</span></span>
                    <input type="text" name="teamName" placeholder="Enter your team name"required  value="<?php if($team_id > 0){ echo get_team_by_id($team_id)->getTeamName(); } ?>" >
                </div>
                <div class="input-box">
                    <span class="details"><?php if($team_id > 0){ echo 'New ';}?>Team Profile Picture</span>
                    <div class="drag-image">
                        <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <h6>Drag & Drop File Here</h6>
                        <p>200px x 200px</p>
                        <span>OR</span>

                        <button type="button">Browse File</button>
                        <input type="file" name="image" accept = "image/*" hidden>
                    </div>
                    <div class="display-image" style="display: none;"></div>
                </div>
            </div>
            <div class="button">
                <input type='submit' value='<?php if($team_id > 0){ echo 'Update Team'; } else { echo 'Create Team';}?>'>
            </div>
            <br>
        </form>
    </div>
</div>

<script src="js/image_upload.js"></script>

<?php require_once '../view/footer.php'; ?>