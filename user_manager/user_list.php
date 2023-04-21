<?php require_once '../view/header.php'; ?>
<link rel="stylesheet" type="text/css" href="styles/user_list.css">

<form class='search-form' action="user_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="username_search" /> 
    <label>Search by Username:</label>
    <input class="user-username-input" type="text" name="username_search">
    <div class="search-button">
        <input  type="submit" value="Search">
    </div>
    <br>
</form>
<div class="user-container">
    <?php foreach ($users as $user) : ?>
        <div class="user-tag" id="<?php echo $user->getId(); ?>">
            <div class="user-details">
                <div class="username">
                    <span><?php echo $user->getUsername(); ?></span>
                </div>
                <div class="user-info">
                    <span id="user-switch-username"><?php echo $user->getSwitchUsername(); ?></span>
                    <span class="user-switch-friendcode"><?php echo $user->getSwitchFriendCode(); ?></span>               
                </div>
                <div class="button-group">
                    <form action="user_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="user_profile" />
                        <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                        <input type="submit" value="Profile">
                    </form>
                    <form action="team_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="user_team_list" /> 
                        <input type="hidden" name="userId" value="<?php echo $user->getId(); ?>">
                        <input class="button-teams" type="submit" value="Teams">
                    </form>
                    <form action="user_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="user_results" /> 
                        <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                        <input type="submit" value="Results">
                    </form>
                </div>   
            </div>
        </div>             
    <?php endforeach; ?>
</div>

<?php require_once '../view/footer.php'; ?>