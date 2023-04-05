<?php require_once '../view/header.php'; ?>
<h1>Please Log in</h1>


<form method='post' action="user_manager/index.php">
    <input type="hidden" name="controllerRequest" value="validate_login"> 
    <span style='color: red'><?php echo $error_message ?></span>
    <br>
    <div>
        <p>Email:</p><input type='text' name='email' value="<?php if ($userLogedin->getEmailAddress() != '') {
            echo $userLogedin->getEmailAddress();
        } else {
            echo 'admin@admin.com';
        } ?>">
    </div>
    <br>
    <div>
        <p>Password:</p><input type='password' name='pass' value="<?php if ($userLogedin->getPassword() != '') {
    echo $userLogedin->getPassword();
} else {
    echo 'password';
} ?>">
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='Login'>
    </div>

    <br>
</form>


<?php require_once '../view/footer.php'; ?>