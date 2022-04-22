<?php

require "connectDB.php";

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$amka = $_POST['amka'];
$afm = $_POST['afm'];
$pid = $_POST['pid'];
// reformat pid to only keep Letters and numbers of id
$pid = str_replace("-","", $pid);
$pid = str_replace(" ","", $pid);

$age = $_POST['age'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$role = $_POST['role'];


// θα κανουμε 2 ελεγχους για την μοναδικοτητα των ΑΦΜ και ΑΜΚΑ στη Βαση Δεδομένων
$questionAMKA = "SELECT AMKA FROM users WHERE AMKA = '$amka'";
$questionAFM = "SELECT AFM FROM users WHERE AFM = '$afm'";

$resultAMKA = $mysqli->query($questionAMKA);
$resultAFM = $mysqli->query($questionAFM);

// εαν ΑΦΜ ή ΑΜΚΑ υπαρχουν ηδη, εμφανιση σχετικου μηνυματος και redirect στο register.php
if ($resultAMKA->num_rows > 0) {
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Η εγγραφή ΔΕΝ πραγματοποιήθηκε. Το Α.Μ.Κ.Α. υπάρχει ήδη.")) {
		history.go (-1);
	}
	</script>';
	exit();
}
else if ($resultAFM->num_rows > 0) {
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Η εγγραφή ΔΕΝ πραγματοποιήθηκε. Το  Α.Φ.Μ υπάρχει ήδη.")) {
		history.go (-1);
	}
	</script>';
	exit();
}
$resultAFM->close();
$resultAMKA->close();

$insertQuery = "INSERT INTO users (uid,  firstname, lastname, amka, afm, pid, age, gender, email, phone, role) VALUES(null, '$firstname', '$lastname', '$amka', '$afm', '$pid', '$age', nullif('$gender', ''), nullif('$email', ''), '$phone', '$role')";

// εαν η εγγραφη του χρηστη πραγματοποιηθει χωρις σφαλμα εμφανιση σχετικου μηνυματος και redirect
// στο register.php, διοτι απο την ιδια σελιδα ο χρηστης μπορει να κανει login
if ($mysqli->query($insertQuery) === true) {
	echo '  <script language="javascript" type="text/javascript">
	if (!alert ("Συγχαρητήρια! Η εγγραφή πραγματοποιήθηκε. Μπορείτε πλέον να συνδεθείτε.")) {
		location.href = "../register.php";
	}
	</script>';
	exit();
}
// εαν προκυψει καποιο αλλο σφαλμα εμφανιση σχετικου μηνυματος αποτυχιας
else {
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Η εγγραφή ΔΕΝ πραγματοποιήθηκε. Παρακαλω επικοινωνηστε με τον System Admin στο\\nwebdeveloper@admin.com")) {
		history.go (-1);
	}
	</script>';
	exit();
}
$mysqli->close(); //Κλείσιμο σύνδεσης με ΒΔ.
?>