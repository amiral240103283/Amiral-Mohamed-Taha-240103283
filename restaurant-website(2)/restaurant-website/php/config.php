<?php
$conn = mysqli_connect(
  "localhost",
  "root",
  "1234",
  "restaurant",
  3306
);

if (!$conn) {
  die("Connection failed");
}
?>
