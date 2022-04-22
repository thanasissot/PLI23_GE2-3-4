<?php 
// used to change the status of vaccination
require "connectDB.php";

$vacdateid = $_POST['vacdateid'];
$status = $_POST['status'];

if ($status == 'ΜΗ ΟΛΟΚΛΗΡΩΜΕΝΟΣ') {
	$status = 'ΟΛΟΚΛΗΡΩΜΕΝΟΣ';
}
else {
	$status = 'ΜΗ ΟΛΟΚΛΗΡΩΜΕΝΟΣ';
}

$question = "UPDATE `vacdates` SET `status`='$status' WHERE `vacdates`.`vacdateid` = '$vacdateid'";

if ($mysqli -> query($question) === true) {
	echo 'true';
}
else {
	echo '';
}
exit();

?>