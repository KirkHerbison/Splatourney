<?php require_once '../view/header.php'; ?> 
<link rel="stylesheet" type="text/css" href="styles/team_register.css"/>
<h1><?php echo $team->getTeamName(); ?>'s Details</h1>
<br>
<form action="admin_manager/index.php" method="post"> 
    <input type="hidden" name="controllerRequest" value="team_update" />
    <input type="hidden" name="teamId" value="<?php echo $team->getId(); ?>"/>
    <input type="hidden" name="teamImageLink" value="<?php echo $team->getTeamImageLink(); ?>"/>
    <div class="container">
        <div class="title">Update <?php echo $team->getTeamName(); ?>'s Details</div>
            <span style='color: red'><?php echo $error_message ?></span>
            <div class="content">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Team Name <span style="color: red;">*</span></span>
                        <input type="text" name="teamName" required  value="<?php echo $team->getTeamName(); ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Team Profile Picture</span>
                        <div class="display-image">
                            <img style=" max-height: 100px; max-width: 100px" src="images/team_images/<?php echo $team->getTeamImageLink(); ?>" alt="<?php echo $team->getTeamName(); ?> team image" />
                        </div>
                    </div>
                    <div class="input-box">
                        <span class="details">Remove Team Image</span>
                        <input type='checkbox' name="removeTeamImage">
                    </div>
                </div>
                <div class="button" style="margin-bottom: 0;">
                    <input type='submit' value='Update'>
                </div>
                </form>
                <br> 
                <form action="admin_manager/index.php" method="post">
                    <input type="hidden" name="controllerRequest" value="cencel_team" />
                    <div class="button" style="margin-top: 0;" >
                        <input type='submit' value='Cancel'>
                    </div>
                </form>
            </div>
        </div>







<?php require_once '../view/footer.php'; ?>