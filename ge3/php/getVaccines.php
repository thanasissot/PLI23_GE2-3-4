<?php 
	// used to assign all Vaccinations Dates By centerid to json notation variable on the DOM
	require "connectDB.php";

	$centerid = $_POST['centerid'];

	$question = "SELECT * FROM vacdates WHERE centerid = '$centerid'";
	$result = $mysqli -> query($question);
	$array = array();

	$index = 0;
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			// retrieve all vac dates that are booked in queried vac center
			$array[$index]['date'] = $row['date1'];
			$array[$index]['time'] = $row['time1'];
			$array[$index]['status'] = $row['status'];
			$array[$index]['uid'] = $row['uid'];
			$index = $index + 1;
		}

		$result -> close(); //Κλείσιμο $result για καθαρισμό μνήμης.
		$mysqli -> close(); //Κλείσιμο σύνδεσης με ΒΔ.
		// εαν υπαρχουν κλεισμενες ημερομενιες επιστρεφουμε αυτες
		echo json_encode($array);
	}
	else {
		// αλλιως ενα κενο string 
		echo json_encode('');
	}

?>