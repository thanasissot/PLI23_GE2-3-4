<?php
// used to DELETE a booked appoitment for vaccination
session_start();

require "connectDB.php";

$vacdateid = $_SESSION['vacdateid'];

$myQuery = "DELETE FROM vacdates WHERE vacdateid = '$vacdateid'";
$result = $mysqli -> query($myQuery);

// επιτυχής διαγραφή καθαρισμα των μεταβλητων απο το SESSION και redirect στο userLanding.php
if ($result) {
	unset($_SESSION['vacdateid']);

	header('Location: ../userLanding.php');
}
else {
	echo '<script language="javascript" type="text/javascript">
            if (!alert ("Κάτι πήγε στραβά!")) {
                history.go (-1);
            }
            </script>';
}

?>
