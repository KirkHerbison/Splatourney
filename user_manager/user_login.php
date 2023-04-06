<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" href="styles/login.css">
<div class="center">
    <form method='post' action="user_manager/index.php">
        <input type="hidden" name="controllerRequest" value="validate_login"> 
        <span style='color: red'><?php echo $error_message ?></span>
        <br>
        <div class="txt_field">
            <input type='text' name='email' rquired value="<?php
            if ($userLogedin->getEmailAddress() != '') {
                echo $userLogedin->getEmailAddress();
            } else {
                echo 'admin@admin.com';
            }
            ?>">
            <label>Email</label>
        </div>
        <br>
        <div class="txt_field">
            <input type='password' name='pass' rquired value="<?php
            if ($userLogedin->getPassword() != '') {
                echo $userLogedin->getPassword();
            } else {
                echo 'password';
            }
            ?>">
            <label>Password:</label>
        </div>
        <br>
        <input type='submit' value='Login'>
        <br>
    </form>
</div>

<?php require_once '../view/footer.php'; ?>