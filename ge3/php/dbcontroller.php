<?php 

// σε περιπτωση που το ραντεβου υπαρχει θελουμε να ανακτησουμε και τα
// στοιχεια του συγκεκριμενου εμβολιαστικού κέντρου
function getCurrentCenterName($centerid) {
	require "connectDB.php";
	$question = "SELECT name FROM centers WHERE centerid = '$centerid'";
	$result = $mysqli -> query($question);
	$array = null;

	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$name = $row['name'];
		}

		$result -> close(); //Κλείσιμο $result για καθαρισμό μνήμης.
		$mysqli -> close(); //Κλείσιμο σύνδεσης με ΒΔ.
		return $name;
	}
	
	return $array;
}

function getAllCenters(){
	require "connectDB.php";
	$question = "SELECT * FROM centers";
	$result = $mysqli -> query($question);
	$centers = [
		0 => array(),
		1 => array()
	];

	if ($result -> num_rows > 0) {
		$index = 0;
		while ($row = $result -> fetch_assoc()) {
			$centers[$index]['centerid'] = $row['centerid'];
			$centers[$index]['name'] = $row['name'];
			$centers[$index]['address'] = $row['address'];
			$centers[$index]['tk'] = $row['tk'];
			$centers[$index]['phone'] = $row['phone'];
			
			$index += 1;
		}
	}

	return $centers;
}

function getCenterByCenterid($centerid) {
	require "connectDB.php";
	$question = "SELECT * FROM centers WHERE centerid = '$centerid'";
	$result = $mysqli -> query($question);
	$center = array();

	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$center['centerid'] = $row['centerid'];
			$center['name'] = $row['name'];
			$center['address'] = $row['address'];
			$center['tk'] = $row['tk'];
			$center['phone'] = $row['phone'];
		}
	}

	return $center;
}

function getVacDate($uid) {
	require "connectDB.php";
	// ψαχνουμε εαν ο χρήστης έχει κλείσει κάποιο ραντεβού
	$question = "SELECT * FROM vacdates WHERE uid = '$uid'";
	$result = $mysqli -> query($question);
	$array = null;

	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$vacdateid = $row['vacdateid'];
			$vdate = $row['date1'];
			$vtime= $row['time1'];
			$vstatus = $row['status'];
			$vcenterid = $row['centerid'];
		}

		$array = [
			"vacdateid" => $vacdateid,
			"vdate" => $vdate,
			"vtime" => $vtime,
			"vstatus" => $vstatus,
			"vcenterid" => $vcenterid,
		];
	}

	return $array;
}

function getUserByUid($uid) {
	require "connectDB.php";

	$question = "SELECT * FROM users WHERE uid = '$uid'";
	$result = $mysqli -> query($question);
	$array = null;

	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$uid = $row['uid'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$amka = $row['amka'];
			$afm = $row['afm'];
			$pid = $row['pid'];
			$age = $row['age'];
			$phone = $row['phone'];
			$gender = $row['gender'];
			$email = $row['email'];
			$role = $row['role'];
		}

		$array = [
				"uid" => $uid,
				"firstname" => $firstname,
				"lastname" => $lastname,
				"amka" => $amka,
				"afm" => $afm,
				"pid" => $pid,
				"age" => $age,
				"phone" => $phone,
				"gender" => $gender,
				"email" => $email,
				"role" => $role
			];
	}

	return $array;
}

function getVacCenterIdByDoctorId ($uid) {
	require "connectDB.php";
	$question = "SELECT * FROM doctors WHERE uid = '$uid'";
	$result = $mysqli -> query($question);
	$centerid = null;

	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$centerid = $row['centerid'];
		}
	}

	return $centerid;
}

function getBookedDatesByCenterId($centerid) {
	require "connectDB.php";
	$question = "SELECT * FROM vacdates WHERE centerid = '$centerid'";
	$result = $mysqli -> query($question);
	$array = array();

	$index = 0;
	if ($result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			// retrieve all vac dates that are booked in queried vac center
			$array[$index]['vacdateid'] = $row['vacdateid'];
			$array[$index]['date'] = $row['date1'];
			$array[$index]['time'] = $row['time1'];
			$array[$index]['status'] = $row['status'];
			$array[$index]['uid'] = $row['uid'];
			$index = $index + 1;
		}

		$result -> close(); //Κλείσιμο $result για καθαρισμό μνήμης.
		$mysqli -> close(); //Κλείσιμο σύνδεσης με ΒΔ.
		// εαν υπαρχουν κλεισμενες ημερομενιες επιστρεφουμε αυτες
		return $array;
	}
	
	return null;
}



?>