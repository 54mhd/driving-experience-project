<?php

function fetchAll($pdo, $table) {
    $stmt = $pdo->query("SELECT * FROM $table");
    return $stmt->fetchAll();
}

function getHazardsForExperience($pdo, $idExperience) {
    $sql = "
        SELECT h.hazardType
        FROM hazard h
        JOIN experience_hazard eh ON h.idHazard = eh.idHazard
        WHERE eh.idExperience = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idExperience]);
    return $stmt->fetchAll();
}
