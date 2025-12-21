<?php
require_once "../inc/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: drivers.php");
    exit;
}

$name = trim($_POST['driverName']);

if ($name === "") {
    die("Driver name cannot be empty");
}

/* Insert driver */
$stmt = $pdo->prepare(
    "INSERT INTO driver (driverName) VALUES (?)"
);
$stmt->execute([$name]);

header("Location: drivers.php");
exit;
