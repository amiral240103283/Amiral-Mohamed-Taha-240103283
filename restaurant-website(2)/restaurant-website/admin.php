<?php
include "php/config.php";
$result = mysqli_query($conn,"SELECT * FROM reservations");
?>

<table border="1">
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Date</th>
  <th>Time</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['date'] ?></td>
  <td><?= $row['time'] ?></td>
</tr>
<?php } ?>
</table>
