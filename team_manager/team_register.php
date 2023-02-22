<?php require_once '../view/header.php'; ?> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/js/vendor/jquery.ui.widget.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/js/jquery.iframe-transport.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/10.7.0/js/jquery.fileupload.min.js"></script>

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
    <div>
        <p>Team Profile Picture: </p>
        <input type="file" name="image" accept = "image/*">
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='Create Team'>
    </div>
    <br>
</form>

<?php require_once '../view/footer.php'; ?>