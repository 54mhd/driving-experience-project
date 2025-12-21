<?php
require_once "../inc/db.php";

$stmt = $pdo->prepare("
INSERT INTO drivingExperience
(date, startTime, endTime, kilometers, idDriver, idRoadType, idWeather, idTraffic)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $_POST['date'],
    $_POST['startTime'],
    $_POST['endTime'],
    $_POST['kilometers'],
    $_POST['idDriver'],
    $_POST['idRoadType'],
    $_POST['idWeather'],
    $_POST['idTraffic']
]);

$idExperience = $pdo->lastInsertId();

if (isset($_POST['hazards']) && is_array($_POST['hazards'])) {

    $stmt = $pdo->prepare(
        "INSERT INTO experience_hazard (idExperience, idHazard)
         VALUES (?, ?)"
    );

    foreach ($_POST['hazards'] as $idHazard) {
        $stmt->execute([$idExperience, (int)$idHazard]);
    }
}

header("Location: dashboard.php");
exit;
