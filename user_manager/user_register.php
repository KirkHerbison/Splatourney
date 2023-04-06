<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" href="styles/register.css"/>

<div class="container">

    <div class="title">Register</div>
    <span style='color: red'><?php echo $error_message ?></span>
    <div class="content">
        <form action="user_manager/index.php" method="post">
            <input type="hidden" name="controllerRequest" value="user_register_confirmation" /> 
            <div class="user-details">
                <div class="input-box">
                    <span class="details">First Name <span style="color: red;">*</span></span>
                    <input type="text" name="firstName" placeholder="Enter your first name"required>
                </div>
                <div class="input-box">
                    <span class="details">Last Name <span style="color: red;">*</span></span>
                    <input type="text" name="lastName" placeholder="Enter your last name" required>
                </div>
                <div class="input-box">
                    <span class="details">Show Name On Profile</span>
                    <input type="checkbox" name="showName">
                </div>
                <div class="input-box">
                    <span class="details">Email <span style="color: red;">*</span></span>
                    <input type='text' name='emailAddress' placeholder="Enter your email"required>
                </div>
                <div class="input-box">
                    <span class="details">Switch Friend Code</span>
                    <input type='text' name='friendCode' placeholder="example: SW-1111-2222-3333">
                </div>
                <div class="input-box">
                    <span class="details">Switch Username</span>
                    <input type='text' name='switchUsername' placeholder="Enter your switch username">
                </div>
                <div class="input-box">
                    <span class="details">Splashtag</span>
                    <input type='text' name='splashtag' placeholder="example: Mr.Coco#1414">
                </div>
                <div class="input-box">
                    <span class="details">Discord Username</span>
                    <input type='text' name='discordUsername' placeholder="LittleTimmy#1234">
                </div>
                                <div class="input-box">
                    <span class="details">username <span style="color: red;">*</span></span>
                    <input type='text' name='username' placeholder="Enter a username" required>
                </div>
                <div class="input-box">
                    <span class="details">Password <span style="color: red;">*</span></span>
                    <input type='password' name='password' placeholder="Enter a password" required>
                </div>
            </div>
            <div class="button">
                <input type='submit' value='Register'>
            </div>
        </form>
    </div>
</div>





<?php require_once '../view/footer.php'; ?>