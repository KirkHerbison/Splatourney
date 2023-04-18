<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" href="styles/login.css">
<div class="center">
    <div class='div_form'>
        <span style='color: red'><?php echo $error_message ?></span>
        <br>
        <div class="txt_field">
            <input type='email' id='email' name='email' rquired value="<?php
            if ($userLogedin->getEmailAddress() != '') {
                echo $userLogedin->getEmailAddress();
            } else {
                echo 'admin@admin.com';
            }
            ?>">
            <label>Email:</label>
        </div>
        <br>
        <div class="txt_field">
            <input type='password' id="pass" name='pass' rquired value="<?php
            if ($userLogedin->getPassword() != '') {
                echo $userLogedin->getPassword();
            } else {
                echo 'password';
            }
            ?>">
            <label>Password:</label>
        </div>
        <br>
        <button id="loginButton">Login</button>
        <br>
    </div>
</div>

<script src="js/login.js"></script>

<?php require_once '../view/footer.php'; ?>