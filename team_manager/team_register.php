<?php require_once '../view/header.php'; ?> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><!--for image upload -->
<script src="https://use.fontawesome.com/releases/v5.7.2/css/all.css"></script><!-- for image upload -->
<link rel="stylesheet" type="text/css" href="styles/image_upload.css"><!-- for image upload -->

<h1>Create Team</h1>
<span style='color: red'><?php echo $error_message ?></span>
<form action="team_manager/index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="controllerRequest" value="team_register_confirmation" /> 
    <br>
    <div>
        <p>Team Name: </p>
        <input type="text" name="teamName" value="My Team Name"><p class ="requiredField">*</p>
    </div>
    <br>
    <div><!-- Start for image upload -->
        <p>Team Profile Picture: </p>
            <div class="drag-image">
            <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <h6>Drag & Drop File Here</h6>
            <span>OR</span>
            <button type="button">Browse File</button>
            <input type="file" name="image" accept = "image/*" hidden>
        </div>
        <div class="display-image" style="display: none;"></div>
    </div><!-- end for image upload -->
    <br>
    <div>
        <p></p><input type='submit' value='Create Team'>
    </div>
    <br>
</form>


<script src="js/image_upload.js"></script>

<?php require_once '../view/footer.php'; ?>