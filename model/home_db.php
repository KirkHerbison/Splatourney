<?php
require_once('model/Tournament.php');

function get_upcoming() {
    $db = Database::getDB();
    $tournamentArray = array();
    $query = 'SELECT * FROM tournament
                WHERE tournament_date >NOW()
                ORDER BY ABS(DATEDIFF(tournament_date, NOW()))
                LIMIT 2';
    $statement = $db->prepare($query);
    $statement->execute();
    $tournaments = $statement->fetchAll();
    $statement->closeCursor();
    foreach ($tournaments as $tournament) {
        $tournamentObject = new Tournament($tournament['ID'],
                $tournament['tournament_owner_id'],
                $tournament['tournament_organizer_name'],
                $tournament['tournament_type_id'],
                $tournament['tournament_banner_link'],
                $tournament['tournament_name'],
                $tournament['tournament_date'],
                $tournament['tournament_registration_deadline'],
                $tournament['tournament_about'],
                $tournament['tournament_prizes'],
                $tournament['tournament_contact'],
                $tournament['tournament_rules'],
                $tournament['isActive']);
        $tournamentArray[] = $tournamentObject;
    }
    return $tournamentArray;
}