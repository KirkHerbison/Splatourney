<?php require_once '../view/header.php'; ?> 

<h1>Create Tournament</h1>
<span style='color: red'><?php echo $error_message ?></span>
<form action="team_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="team_register_confirmation" /> 
    <br>
    <div>
        <p>Organization Name: </p>
        <input type="text" name="teamName" value="My Tournament Name">
    </div>
    <br>
    <div>
        <p>Team Profile Picture: </p>
        <input type="file" name="teamPicture">
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='Create Team'>
    </div>
    <br>
</form>

<?php require_once '../view/footer.php'; ?>