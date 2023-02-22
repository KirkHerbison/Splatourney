<?php require_once '../view/header.php'; ?>
<h1>User List (May Remove In Future. Used to test user_info)</h1>
<form action="team_manager/index.php" method="POST">
    <input type="hidden" name="controllerRequest" value="team_search_by_name" /> 
    <br>
    <div>
        <p>Search by team name:</p>
        <input type="text" name="team_search">
    </div>
    <br>
    <div>
        <p></p><input type="submit" value="Search">
    </div>
    <br>
</form>

<table>
    <tr>
        <th>Name</th>
        <th>Team Captain</th>
    </tr>
    <?php foreach ($teams as $team) : ?>
        <tr>
            <td><?php echo $team->getTeamName(); ?></td>
            <td><?php echo $team->getTeamCaptainName(); ?></td>
            <td>
                <form action="team_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="user_profile" /> 
                    <input type="hidden" name="user_id" value="<?php echo $team->getId(); ?>">
                    <input type="submit" value="View Details">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>