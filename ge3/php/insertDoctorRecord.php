<?php 
require "connectDB.php";

$uid = $_POST['uid'];
$centerid = $_POST['centerid'];

$question = "INSERT INTO `doctors`(`doctorid`, `uid`, `centerid`) VALUES (null,'$uid','$centerid')";

if ($mysqli -> query($question) === true) {
	echo 'true';
}
else {
	echo '';
}
exit();

?>