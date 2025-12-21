<?php
require_once "../inc/db.php";
require_once "../inc/functions.php";

$drivers = $pdo->query(
    "SELECT * FROM driver WHERE active = 1 ORDER BY driverName"
)->fetchAll();

$roads    = fetchAll($pdo, "roadType");
$weathers = fetchAll($pdo, "weather");
$traffic  = fetchAll($pdo, "traffic");
$hazards  = fetchAll($pdo, "hazard");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Driving Experience</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
  <h1>➕ Add Driving Experience</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="drivers.php">Drivers</a>
    <a href="dashboard.php">Dashboard</a>
  </nav>
</header>

<div class="container">
<div class="card">
<form method="post" action="save.php">

  <div class="field">
    <label>Date</label>
    <input type="date" name="date" required>
  </div>

  <div class="field">
    <label>Start Time</label>
    <input type="time" name="startTime" required>
  </div>

  <div class="field">
    <label>End Time</label>
    <input type="time" name="endTime" required>
  </div>

  <div class="field">
    <label>Kilometers</label>
    <input type="number" step="0.1" name="kilometers" required>
  </div>

  <div class="field">
    <label>Driver</label>
    <select name="idDriver" required>
      <?php foreach ($drivers as $d): ?>
        <option value="<?= $d['idDriver'] ?>">
          <?= htmlspecialchars($d['driverName']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Road Type</label>
    <select name="idRoadType">
      <?php foreach ($roads as $r): ?>
        <option value="<?= $r['idRoadType'] ?>">
          <?= htmlspecialchars($r['roadTypeName']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Weather</label>
    <select name="idWeather">
      <?php foreach ($weathers as $w): ?>
        <option value="<?= $w['idWeather'] ?>">
          <?= htmlspecialchars($w['weatherType']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Traffic</label>
    <select name="idTraffic">
      <?php foreach ($traffic as $t): ?>
        <option value="<?= $t['idTraffic'] ?>">
          <?= htmlspecialchars($t['trafficType']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Hazards</label>

    <?php foreach ($hazards as $h): ?>
      <label>
        <input
          type="checkbox"
          name="hazards[]"
          value="<?= $h['idHazard'] ?>"
          autocomplete="off"
        >
        <?= htmlspecialchars($h['hazardType']) ?>
      </label>
    <?php endforeach; ?>
  </div>


  <div style="flex-basis:100%; text-align:right;">
    <button type="submit">Save Experience</button>
  </div>

</form>
</div>
</div>

</body>
</html>
