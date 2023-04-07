<?php require_once '../view/header.php'; ?> 

<h1><?php echo $user->getUsername(); ?>'s Profile</h1>
<br>
<form action="admin_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="user_update" />
    <input type="hidden" name="userId" value="<?php echo $user->getId(); ?>"/>
    <div>
        <label>Full Name:</label>
        <input type='text' value="<?php if ($user->getDisplayName() == 1) {
    echo $user->getFirstName(); ?> <?php echo $user->getLastName();
} ?>" readonly>
    </div>
    <br>
    <div>
        <label>Email:</label>
        <input type='text' value="<?php echo $user->getEmailAddress(); ?>" readonly>
    </div>
    <br>
    <div>
        <label>Username:</label>
        <input type='text' value="<?php echo $user->getUsername(); ?>" readonly>
    </div>
    <br>
    <div>
        <label>Switch Friend Code:</label>
        <input type='text' name="friendCode" value="<?php echo $user->getSwitchFriendCode(); ?>">
    </div>
    <br>
    <div>
        <label>Switch Username:</label>
        <input type='text' name="switchUsername" value="<?php echo $user->getSwitchUsername(); ?>">
    </div>
    <br>
    <div>
        <label>Splashtag:</label>
        <input type='text' name="splashtag" value="<?php echo $user->getSplashtag(); ?>">
    </div>
    <br>
    <div>
        <label>Discord Username:</label>
        <input type='text' name="discordUsername" value="<?php echo $user->getDiscordUsername(); ?>">
    </div>
    <br>
    <div class="button">
        <input type='submit' value='Update'>
    </div>
</form>

<?php require_once '../view/footer.php'; ?>