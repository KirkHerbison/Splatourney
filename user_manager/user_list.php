<?php require_once '../view/header.php'; ?>
<h1>User List (May Remove In Future. Used to test user_info)</h1>
<form action="user_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="username_search" /> 
    <br>
    <div>
        <p>Search by last username:</p>
        <input type="text" name="username_search">
    </div>
    <br>
    <div>
        <p></p><input type="submit" value="Search">
    </div>
    <br>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>View User Info</th>
    </tr>
    <?php foreach ($users as $user) : ?>
        <?php if ($user->getIsActive() == 1) { ?>
        <tr>
            <td><?php echo $user->getId(); ?></td>
            <td><?php if($user->getDisplayName() == 1){echo $user->getFirstName(); ?><br><?php echo $user->getLastName();} ?></td>
            <td><?php echo $user->getUsername(); ?></td>
            <td>
                <form action="user_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="user_profile" /> 
                    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>">
                    <input type="submit" value="View Profile">
                </form>
            </td>
        </tr>
        <?php }?>
<?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>