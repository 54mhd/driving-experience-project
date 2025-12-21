<?php
require_once "../inc/db.php";

/* Only ACTIVE drivers are shown */
$sql = "
SELECT d.idDriver, d.driverName, COUNT(e.idExperience) AS used
FROM driver d
LEFT JOIN drivingExperience e ON d.idDriver = e.idDriver
WHERE d.active = 1
GROUP BY d.idDriver
ORDER BY d.driverName
";
$drivers = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drivers</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
  <h1>👤 Drivers</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="form.php">Add Experience</a>
    <a href="dashboard.php">Dashboard</a>
  </nav>
</header>

<div class="container">

  <!-- ADD DRIVER -->
  <div class="card">
    <h2>Add a Driver</h2>

    <form method="post" action="save_driver.php">
      <div class="field">
        <label>Driver Name</label>
        <input type="text" name="driverName" required>
      </div>

      <div style="flex-basis:100%; text-align:right;">
        <button type="submit">Add Driver</button>
      </div>
    </form>
  </div>

  <!-- DRIVER LIST -->
  <div class="card">
    <h2>Existing Drivers</h2>

    <table>
      <tr>
        <th>Name</th>
        <th>Used In</th>
      </tr>

      <?php foreach ($drivers as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d['driverName']) ?></td>
          <td><?= $d['used'] ?> experience(s)</td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

</div>

</body>
</html>
