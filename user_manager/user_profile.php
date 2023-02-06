<?php require_once '../view/header.php'; ?> 

<h1><?php echo $user->getUsername(); ?>'s Profile</h1>
    <br>
    <div>
        <p>Full Name: <?php if($user->getDisplayName() == 1){echo $user->getFirstName(); ?> <?php echo $user->getLastName();} ?></p>
    </div>
    <br>
    <div>
        <p>username: <?php echo $user->getUsername(); ?></p>
    </div>
    <br>
    <div>
        <p>Switch Friend Code: <?php echo $user->getSwitchFriendCode(); ?></p>
    </div>
    <br>
    <div>
        <p>Switch Username: <?php echo $user->getSwitchUsername(); ?></p>
    </div>
    <br>
    <div>
        <p>Splashtag: <?php echo $user->getSplashtag(); ?></p>
    </div>
    <br>
    <div>
        <p>Discord Username: <?php echo $user->getDiscordUsername(); ?></p>
    </div>
    <br>
</form>

<?php require_once '../view/footer.php'; ?>