<?php

session_start();

require "connectDB.php";

$amka = $_POST['amka'];
$afm = $_POST['afm'];

$question = "SELECT uid, role FROM users WHERE amka = '$amka' AND afm = '$afm'";
$result = $mysqli -> query($question);

if ($result -> num_rows == 0) {
    echo    '<script language="javascript" type="text/javascript">
            if (!alert ("Τα στοιχεία πρόσβασης είναι λανθασμένα! Προσπαθήστε ξανά.")) {
                history.go (-1);
            }
            </script>';
}
else {

	while ($row = $result -> fetch_assoc()) {
		$_SESSION['uid'] = $row['uid'];
		$_SESSION['role'] = $row['role'];
	}

	if ($_SESSION['role'] == 'Πολίτης') {
		$_SESSION['userLoggedIn'] = true;
		
		while ($row = $result -> fetch_assoc()) {
			$_SESSION['uid'] = $row['uid'];
		}

		// redirect στο Landing page ενος Πολίτη
		header("Location: ../userLanding.php");
	}
	else if ($_SESSION['role'] == 'Γιατρός') {
		$_SESSION['doctorLoggedIn'] = true;
		header("Location: ../doctorLanding.php");
	}
	else {
		echo    '<script language="javascript" type="text/javascript">
            if (!alert ("Κάτι πήγε πολύ στραβά! Δοκιμάστε πάλι.")) {
                history.go (-1);
            }
            </script>';
	}
	
}

$result -> close(); //Κλείσιμο $result για καθαρισμό μνήμης.
$mysqli -> close(); //Κλείσιμο σύνδεσης με ΒΔ.

?>