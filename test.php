<!DOCTYPE html>
<html>
<body>

<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
$date1=date_create("18-11-2020");
$date2=date_create("18-12-2020");
$endDate = date_create("2020-11-06 14:30:00");
$date = strtotime("06-11-2020 14:35:00");
$date_time = date_create($date);
$diff=date_diff($date1,$date2);
$time = date('d-m-Y H:i:s');
$checkIfExpired = $date < time() ? 'expired' : 'active';
echo $checkIfExpired . " jam : " . $_SESSION['user'];
// echo $checkIfExpired . '</br>';
// echo date_format($endDate,"U = Y-m-d H:i:s");

// // %a outputs the total number of days
// echo $diff->format("Total number of days: %a.");
// echo "<br>";

// // %R outputs + beacause $date2 is after $date1 (a positive interval)
// echo $diff->format("Total number of days: %R%a.");
// echo "<br>";

// // %d outputs the number of days that is not already covered by the month
// echo $diff->format("Month: %m, days: %d.");
?>

</body>
</html>
