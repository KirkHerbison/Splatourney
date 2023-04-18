<?php require_once '../view/header.php'; ?> 

<h1><?php echo $user->getUsername(); ?>'s Profile</h1>
<div class='user-info-container'>
    <br>
    <?php if($user->getDisplayName() == 1){ ?>
    <div class='user-info'>
        <label>Full Name:</label>
        <p><?php echo $user->getFirstName().' '.$user->getLastName();?></p>
    </div>
    <?php } ?>
    <br>
    <div class='user-info'>
        <label>Username:</label>
        <p><?php echo $user->getUsername(); ?></p>
    </div>
    <br>
    <div class='user-info'>
        <label>Switch Friend Code:</label>
        <p><?php echo $user->getSwitchFriendCode(); ?></p>
    </div>
    <br>
    <div class='user-info'>
        <label>Switch Username:</label>
        <p><?php echo $user->getSwitchUsername(); ?></p>
    </div>
    <br>
    <div class='user-info'>
        <label>Splashtag:</label>
        <p><?php echo $user->getSplashtag(); ?></p>
    </div>
    <br>
    <div class='user-info'>
        <label>Discord Username:</label>
        <p><?php echo $user->getDiscordUsername(); ?></p>
    </div>
    <br>
</div>
<?php require_once '../view/footer.php'; ?>