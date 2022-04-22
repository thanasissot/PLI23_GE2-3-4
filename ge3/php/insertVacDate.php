<?php 
session_start();
require "connectDB.php";

$centerid = $_POST['centerId'];
$date = $_POST['date'];
$time = $_POST['time'];
$uid = $_SESSION['uid'];


$insertQuery = "INSERT INTO vacdates (vacdateid, uid, centerid, date1, time1, status) VALUES (null, '$uid','$centerid','$date','$time', 'ΜΗ ΟΛΟΚΛΗΡΩΜΕΝΟΣ')";

if ($mysqli->query($insertQuery) === true) {
	echo 'true';
}
else {
	echo '';
}
exit();


?>