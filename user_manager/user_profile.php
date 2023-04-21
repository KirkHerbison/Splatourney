<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" type="text/css" href="styles/user_profile.css">

<div class='user-info-container'>
    <div class="divider">    
        <span class="team-name"><?php echo $user->getUsername(); ?></span>
    </div>
    <br><br><br><br><br>
    <div class="info-containter">
        <?php if ($user->getDisplayName() == 1) { ?>
            <div class='user-info'>
                <label>Full Name:</label>
                <p><?php echo $user->getFirstName() . ' ' . $user->getLastName(); ?></p>
            </div>
        <?php } ?>
        <div class='user-info'>
            <label>Username:</label>
            <p><?php echo $user->getUsername(); ?></p>
        </div>
        <div class='user-info'>
            <label>Switch Friend Code:</label>
            <p><?php echo $user->getSwitchFriendCode(); ?></p>
        </div>
        <div class='user-info'>
            <label>Switch Username:</label>
            <p><?php echo $user->getSwitchUsername(); ?></p>
        </div>
        <div class='user-info'>
            <label>Splashtag:</label>
            <p><?php echo $user->getSplashtag(); ?></p>
        </div>
        <div class='user-info'>
            <label>Discord Username:</label>
            <p><?php echo $user->getDiscordUsername(); ?></p>
        </div>
    </div>
</div>

<?php require_once '../view/footer.php'; ?>