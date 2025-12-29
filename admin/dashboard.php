<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/auth.php";


if (isset($_GET["confirm"])) {
  $id = (int)$_GET["confirm"];
  $stmt = $pdo->prepare("UPDATE reservations SET status='confirmed' WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: dashboard.php");
  exit;
}


if (isset($_GET["delete"])) {
  $id = (int)$_GET["delete"];
  $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
  $stmt->execute([$id]);
  header("Location: dashboard.php");
  exit;
}

$res = $pdo->query("SELECT * FROM reservations ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>

<header>
  <div class="container navbar">
    <div class="brand">Admin Dashboard</div>

    <div style="display:flex; gap:10px; align-items:center;">
      <span class="muted" style="font-size:14px;">
        Logged in as: <?php echo htmlspecialchars($_SESSION["admin_username"] ?? "admin"); ?>
      </span>
      <a href="logout.php" style="padding:8px 10px;border:1px solid #ddd;border-radius:12px;display:inline-block;">
        Logout
      </a>
    </div>
  </div>
</header>

<section class="section">
  <div class="container">
    <h2>Reservations</h2>
    <p class="lead">Manage incoming reservations.</p>

    <div style="overflow:auto;background:white;border:1px solid #eee;border-radius:18px;">
      <table style="width:100%;border-collapse:collapse;min-width:1000px;">
        <thead>
          <tr style="text-align:left;background:#f7f7f7;">
            <th style="padding:12px;">Name</th>
            <th style="padding:12px;">Phone</th>
            <th style="padding:12px;">Email</th>
            <th style="padding:12px;">Date</th>
            <th style="padding:12px;">Time</th>
            <th style="padding:12px;">Guests</th>
            <th style="padding:12px;">Notes</th>
            <th style="padding:12px;">Status</th>
            <th style="padding:12px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($res as $r): ?>
            <tr style="border-top:1px solid #eee;">
              <td style="padding:12px;"><?php echo htmlspecialchars($r["full_name"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["phone"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["email"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["reservation_date"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["reservation_time"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["guests"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["notes"]); ?></td>
              <td style="padding:12px;"><?php echo htmlspecialchars($r["status"] ?? "pending"); ?></td>

              <td style="padding:12px; display:flex; gap:8px; align-items:center;">
                <?php if (($r["status"] ?? "pending") !== "confirmed"): ?>
                  <a href="?confirm=<?php echo (int)$r["id"]; ?>"
                     onclick="return confirm('Confirm this reservation?')"
                     style="padding:8px 10px;border:1px solid #ddd;border-radius:12px;display:inline-block;">
                    Confirm
                  </a>
                <?php else: ?>
                  <span class="muted">Confirmed</span>
                <?php endif; ?>

                <a href="?delete=<?php echo (int)$r["id"]; ?>"
                   onclick="return confirm('Delete this reservation?')"
                   style="padding:8px 10px;border:1px solid #ddd;border-radius:12px;display:inline-block;">
                  Delete
                </a>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (count($res) === 0): ?>
            <tr><td style="padding:12px;" colspan="9">No reservations yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</section>

</body>
</html>
