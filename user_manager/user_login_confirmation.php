<?php require_once '../view/header.php'; ?>


<h1><?php echo $login_message; ?></h1>
<form method='post' action='user_manager/index.php'>
    <input type="hidden" name="controllerRequest" value="login_user"> 

    <div>
        <p>Customer ID:</p> <p class = "rightSideForm"><?php echo $user->getId(); ?></p>
    </div>
    <br>
    <div>
        <p>Full Name:</p><p class="rightSideForm"><?php echo $user->getFirstName(); ?> <?php echo $user->getLastName(); ?></p>
    </div>
    <br>
    <div>
        <p>Email:</p><p class="rightSideForm"><?php echo $user->getEmailAddress(); ?></p>  
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='return to login'>
    </div>

    <br>
</form>

<?php require_once '../view/footer.php'; ?>