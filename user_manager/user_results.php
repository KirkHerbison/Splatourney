<?php require_once '../view/header.php'; ?>

<h1><?php echo $user->getUsername(); ?>'s Results</h1>

<table class="content-table">
            <thead>
                <tr>
                    <th>Tournament Name</th>
                    <th>Team Name</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><p><?php echo get_tournament_by_id($result->getTournamentId())->getTournamentName(); ?></p></td>
                            <td><p><?php echo get_team_by_id($result->getTeamId())->getTeamName(); ?></p></td>
                            <td><p><?php echo $result->getResult(); ?></p></td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

<?php require_once '../view/footer.php'; ?>