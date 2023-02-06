<?php  require_once '../view/header.php'; ?> 

<form method='post' action='user_manager/index.php'>
    <input type="hidden" name="controllerRequest" value="user_register" />
    <h1>Registration Success</h1>
    <div>
        <p>First Name:</p><p class ="rightSideForm"><?php {echo $user->getFirstName();}?></p>
    </div>
    <br>
    <div>
            <p>Last Name:</p><p class ="rightSideForm"><?php {echo $user->getLastName();}?></p>
    </div>
    <br>
    <div>
        <p>Email:</p><p class ="rightSideForm"><?php {echo $user->getEmailAddress();}?></p>
    </div>
    <br>
    <div>
        <p>Password:</p><p class="rightSideForm"><?php {echo $user->getPassword();}?></p>
    </div>
    <br>
    <div>
        <p>username:</p><p class="rightSideForm"><?php {echo $user->getUsername();}?></p>
    </div>
    <br>
    <div>
        <p>Switch-Friend-Code:</p><p class="rightSideForm"><?php {echo $user->getSwitchFriendCode();}?></p>
    </div>
    <br>
    <div>
        <p>switch_username:</p><p class="rightSideForm"><?php {echo $user->getSwitchUsername();}?></p>
    </div>
    <br>
    <div>
        <p>Splashtag:</p><p class="rightSideForm"><?php {echo $user->getSplashtag();}?></p>
    </div>
    <br>
    <div>
        <p>Discord Username:</p><p class="rightSideForm"><?php {echo $user->getDiscordUsername();}?></p>
    </div>
    <div>
        <p>Discord Client Secret:</p><p class="rightSideForm"><?php {echo $user->getDiscordClientSecret();}?></p>
    </div>
    <div>
        <p>isActive:</p><p class="rightSideForm"><?php {echo $user->getIsActive();}?></p>
    </div>
    <div>
        <p>display name:</p><p class="rightSideForm"><?php {echo $user->getDisplayName();}?></p>
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='return to register'>
    </div>
    <br>
</form>

<?php  require_once '../view/footer.php'; ?> 
