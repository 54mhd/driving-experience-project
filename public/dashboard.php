<?php
require_once "../inc/db.php";
require_once "../inc/functions.php";

/* -----------------------------
   Main experiences list
   (keep experiences even if driver was deleted)
----------------------------- */
$experiences = $pdo->query("
SELECT
  d.idExperience,
  d.date,
  d.kilometers,
  dr.driverName,
  w.weatherType,
  r.roadTypeName,
  t.trafficType
FROM drivingExperience d
LEFT JOIN driver dr ON d.idDriver = dr.idDriver
JOIN weather w ON d.idWeather = w.idWeather
JOIN roadType r ON d.idRoadType = r.idRoadType
JOIN traffic t ON d.idTraffic = t.idTraffic
ORDER BY d.date DESC
")->fetchAll();

/* -----------------------------
   Total kilometers
----------------------------- */
$totalKm = $pdo->query(
    "SELECT SUM(kilometers) FROM drivingExperience"
)->fetchColumn();

/* -----------------------------
   Longest & shortest experience
----------------------------- */
$maxKm = $pdo->query(
    "SELECT MAX(kilometers) FROM drivingExperience"
)->fetchColumn();

$minKm = $pdo->query(
    "SELECT MIN(kilometers) FROM drivingExperience"
)->fetchColumn();

/* -----------------------------
   Kilometers per driver
   (ONLY existing drivers)
----------------------------- */
$kmByDriver = $pdo->query("
SELECT
  dr.driverName,
  SUM(d.kilometers) AS totalKm
FROM drivingExperience d
JOIN driver dr ON d.idDriver = dr.idDriver
GROUP BY dr.idDriver
ORDER BY totalKm DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
  <h1>📊 Dashboard</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="form.php">Add Experience</a>
    <a href="drivers.php">Drivers</a>
  </nav>
</header>

<div class="container">

  <!-- TOTAL KM -->
  <div class="card">
    <h2>Total Kilometers</h2>
    <div class="stat"><?= $totalKm ?> km</div>
  </div>

  <!-- LONGEST & SHORTEST -->
  <div class="card">
    <h2>Distance Statistics</h2>
    <p><strong>Longest experience:</strong> <?= $maxKm ?> km</p>
    <p><strong>Shortest experience:</strong> <?= $minKm ?> km</p>
  </div>

  <!-- KM PER DRIVER (NO DELETED DRIVERS) -->
  <div class="card">
    <h2>Kilometers per Driver</h2>

    <table>
      <tr>
        <th>Driver</th>
        <th>Total Kilometers</th>
      </tr>

      <?php foreach ($kmByDriver as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['driverName']) ?></td>
          <td><?= $row['totalKm'] ?> km</td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- EXPERIENCES TABLE -->
  <div class="card">
    <h2>All Driving Experiences</h2>

    <table>
      <tr>
        <th>Date</th>
        <th>KM</th>
        <th>Driver</th>
        <th>Weather</th>
        <th>Road</th>
        <th>Traffic</th>
        <th>Hazards</th>
      </tr>

      <?php foreach ($experiences as $e): ?>
        <tr>
          <td><?= $e['date'] ?></td>
          <td><?= $e['kilometers'] ?></td>
          <td><?= htmlspecialchars($e['driverName'] ?? '') ?></td>
          <td><?= htmlspecialchars($e['weatherType']) ?></td>
          <td><?= htmlspecialchars($e['roadTypeName']) ?></td>
          <td><?= htmlspecialchars($e['trafficType']) ?></td>
          <td>
            <?php
              $hz = getHazardsForExperience($pdo, $e['idExperience']);
              foreach ($hz as $h) {
                echo "<span class='badge'>{$h['hazardType']}</span>";
              }
            ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

</div>

</body>
</html>
