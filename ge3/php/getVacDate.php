<?php

session_start();

require "connectDB.php";

function getVacDate($uid) {
	// ψαχνουμε εαν ο χρήστης έχει κλείσει κάποιο ραντεβού
	$questionVacDate = "SELECT * FROM vacdates WHERE uid = '$uid'";
	$resultVacdate = $mysqli -> query($questionVacDate);

	// εαν εχει κλεισει ραντεβου αναθετουμε τις μεταβλητες ωστε να τις εμφανισουμε
	// στο καταλληλο πίνακα
	if ($resultVacdate -> num_rows > 0) {
		while ($row = $resultVacdate -> fetch_assoc()) {
			$vacdateid['vacdateid'] = $row['vacdateid'];
			$vdate['vdate'] = $row['date'];
			$vtime['vtime'] = $row['time'];
			$vstatus['vstatus'] = $row['status'];
			$vcenterid['vcenterid'] = $row['centerid'];
		}

		$array = [
			"vacdateid" => $vacdateid,
			"vdate" => $vdate,
			"vtime" => $vtime,
			"vstatus" => $vstatus,
			"vcenterid" => $vcenterid,
		]

	}
	$resultVacdate -> close(); //Κλείσιμο $result για καθαρισμό μνήμης.
	$mysqli -> close(); //Κλείσιμο σύνδεσης με ΒΔ.

	return null;
}


?>