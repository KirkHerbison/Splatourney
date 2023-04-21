<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" href="styles/register.css"/>

<div class="container">
    <div class="title"><?php echo $user->getUsername(); ?>'s Profile</div>
    <span style='color: red'><?php echo $error_message ?></span>
    <div class="content">
        <form action="admin_manager/index.php" method="post"> 
            <input type="hidden" name="controllerRequest" value="user_update" />
            <input type="hidden" name="userId" value="<?php echo $user->getId(); ?>" />
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Full Name</span>
                    <input type='text' value="<?php if ($user->getDisplayName() == 1) { echo $user->getFirstName(); ?> <?php echo $user->getLastName();} ?>" readonly>
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type='text' value="<?php echo $user->getEmailAddress(); ?>" readonly>
                </div>
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type='text' value="<?php echo $user->getUsername(); ?>" readonly>
                </div>
                <div class="input-box">
                    <span class="details">Switch Friend Code</span>
                    <input type='text' name="friendCode" value="<?php echo $user->getSwitchFriendCode(); ?>">
                </div>
                <div class="input-box">
                    <span class="details">Switch Username</span>
                    <input type='text' name="switchUsername" maxLength="10" value="<?php echo $user->getSwitchUsername(); ?>">
                </div>
                <div class="input-box">
                    <span class="details">Splashtag</span>
                    <input type='text' name="splashtag" value="<?php echo $user->getSplashtag(); ?>">
                </div>
                <div class="input-box">
                    <span class="details">Discord Username</span>
                    <input type='text' name="discordUsername" value="<?php echo $user->getDiscordUsername(); ?>">
                </div>
            </div>
            <div class="button">
                <input type='submit' value='Update'>               
            </div>  
        </form>
    </div>
</div>


<?php require_once '../view/footer.php'; ?>