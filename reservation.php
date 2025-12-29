<?php
require_once __DIR__ . "/includes/config.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $full_name = trim($_POST["full_name"] ?? "");
  $phone = trim($_POST["phone"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $date = $_POST["reservation_date"] ?? "";
  $time = $_POST["reservation_time"] ?? "";
  $guests = (int)($_POST["guests"] ?? 0);
  $notes = trim($_POST["notes"] ?? "");

  if ($full_name === "" || $phone === "" || $email === "" || $date === "" || $time === "" || $guests <= 0) {
    $error = "Please fill all required fields.";
  } else {
   $stmt = $pdo->prepare("INSERT INTO reservations
(full_name, phone, email, reservation_date, reservation_time, guests, notes, status)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->execute([$full_name, $phone, $email, $date, $time, $guests, $notes, "pending"]);

    $success = "Reservation submitted successfully!";
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reservation</title>
  <link rel="stylesheet" href="css/style.css"/>
</head>
<body>

<header>
  <div class="container navbar">
    <div class="brand">TastyBites</div>
    <button class="menu-btn">Menu</button>
    <nav class="nav-links">
      <a href="index.html">Home</a>
      <a href="menu.html">Menu</a>
      <a href="gallery.html">Gallery</a>
      <a href="reservation.php">Reservation</a>
      <a href="admin/login.php">Admin</a>
    </nav>
  </div>
</header>

<section class="section">
  <div class="container">
    <h2>Reserve a Table</h2>
    <p class="lead">Fill the form and we’ll confirm your booking.</p>

    <?php if ($error): ?>
      <div style="background:#ffecec;border:1px solid #ffb3b3;padding:10px;border-radius:12px;margin-bottom:12px;">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div style="background:#ecfff1;border:1px solid #9be7b0;padding:10px;border-radius:12px;margin-bottom:12px;">
        <?php echo htmlspecialchars($success); ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="row">
        <input name="full_name" placeholder="Full Name" required />
        <input name="phone" placeholder="Phone" required />
      </div>

      <div class="row">
        <input type="email" name="email" placeholder="Email" required />
        <select name="guests" required>
          <option value="">Guests</option>
          <option>1</option><option>2</option><option>3</option><option>4</option>
          <option>5</option><option>6</option><option>7</option><option>8</option>
        </select>
      </div>

      <div class="row">
        <input type="date" name="reservation_date" required />
        <input type="time" name="reservation_time" required />
      </div>

      <textarea name="notes" placeholder="Notes (optional)"></textarea>
      <button type="submit">Submit Reservation</button>
    </form>
  </div>
</section>

<footer><div class="container">© 2025 TastyBites</div></footer>
<script src="js/main.js"></script>
</body>
</html>
