<?php
require_once "../inc/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: drivers.php");
    exit;
}

$action = $_POST['action'];

if ($action === "add") {
    $name = trim($_POST['driverName']);

    if ($name !== "") {
        $stmt = $pdo->prepare(
            "INSERT INTO driver (driverName, active) VALUES (?, 1)"
        );
        $stmt->execute([$name]);
    }
}

/* PERMANENT HIDE (soft delete, one-way) */
if ($action === "deactivate") {
    $idDriver = (int) $_POST['idDriver'];

    $stmt = $pdo->prepare(
        "UPDATE driver SET active = 0 WHERE idDriver = ?"
    );
    $stmt->execute([$idDriver]);
}

header("Location: drivers.php");
exit;
