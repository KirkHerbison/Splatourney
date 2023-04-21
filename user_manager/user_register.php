<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" href="styles/register.css"/>

<div class="container">
    <div class="title"><?php if($userLogedin->getId() > 0){ echo 'Edit';} else{ echo 'Register';} ?></div>
    <span style='color: red'><?php echo $error_message ?></span>
    <div class="content">
        <form action="user_manager/index.php" method="post">    
            <div class="user-details">
                <div class="input-box">
                    <span class="details">First Name <span style="color: red;">*</span></span>
                    <input type="text" name="firstName" placeholder="Enter your first name"required value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getFirstName();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Last Name <span style="color: red;">*</span></span>
                    <input type="text" name="lastName" placeholder="Enter your last name" required value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getLastName();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Show Name On Profile</span>
                    <input type="checkbox" name="showName" <?php if($userLogedin->getId() > 0 && $userLogedin->getDisplayName() == 1){ echo 'checked';}?>>
                </div>
                <div class="input-box">
                    <span class="details">Email <span style="color: red;">*</span></span>
                    <input type='text' name='emailAddress' placeholder="Enter your email"required value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getEmailAddress();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Switch Friend Code</span>
                    <input type='text' name='friendCode' placeholder="example: SW-1111-2222-3333" value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getSwitchFriendCode();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Switch Username</span>
                    <input type='text' name='switchUsername' placeholder="Enter your switch username" value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getSwitchUsername();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Splashtag</span>
                    <input type='text' name='splashtag' placeholder="example: Mr.Coco#1414" value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getSplashtag();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Discord Username</span>
                    <input type='text' name='discordUsername' placeholder="LittleTimmy#1234" value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getDiscordUsername();}?>">
                </div>
                                <div class="input-box">
                    <span class="details">username <span style="color: red;">*</span></span>
                    <input type='text' name='username' placeholder="Enter a username" required value="<?php if($userLogedin->getId() > 0){ echo $userLogedin->getUsername();}?>">
                </div>
                <div class="input-box">
                    <span class="details">Password <span style="color: red;">*</span></span>
                    <input type='password' name='password' placeholder="Enter a password" required>
                </div>
            </div>
            <?php if($userLogedin->getId()>0){ ?>
                <div class="button">
                    <input type="hidden" name="controllerRequest" value="user_save_confirmation" /> 
                    <input type='submit' value='Save Changes'>
                    
                </div>
            <?php } else {?>
                <div class="button">
                    <input type="hidden" name="controllerRequest" value="user_register_confirmation" /> 
                    <input type='submit' value='Register'>
                </div>
            <?php } ?>    
        </form>
    </div>
</div>

<?php require_once '../view/footer.php'; ?>