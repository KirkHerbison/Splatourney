<?php

require_once('../model/User.php');
require_once('../model/Tournament.php');

function get_tournament_types() {
    $db = Database::getDB();
    $query = 'SELECT * FROM tournament_type';
    $statement = $db->prepare($query);
    $statement->execute();
    $tournamentType = $statement->fetchAll();
    $statement->closeCursor();
    $tournamentTypes = new TournamnetType($tournamentType['ID'],
            $tournamentType['description'],
            $tournamentType['isActive']);
    return $tournamentTypes;
}
