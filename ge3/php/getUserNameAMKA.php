<?php 
// used to retrieve user FirstName, Lastname and AMKA by uid field of a vacdates table record
require "connectDB.php";

$uid = $_POST['uid'];

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
	}

	$array = [
		"uid" => $uid,
		"firstname" => $firstname,
		"lastname" => $lastname,
		"amka" => $amka
	];
	
		// εαν υπαρχουν κλεισμενες ημερομενιες επιστρεφουμε αυτες
	echo json_encode($array);
}

else {
		// αλλιως ενα κενο string 
	echo json_encode('');
}

?>