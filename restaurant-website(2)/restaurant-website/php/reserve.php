<?php
include "config.php";

$name = $_POST['name'];
$email = $_POST['email'];
$date = $_POST['date'];
$time = $_POST['time'];

mysqli_query($conn,
"INSERT INTO reservations (name,email,date,time)
VALUES ('$name','$email','$date','$time')");

echo "Reservation submitted successfully";
?>
