<?php
session_start();
require "php/dbController.php";

if( ! isset($_SESSION['doctorLoggedIn'])) {
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Για να εισέλθετε σε αυτή τη σελίδα πρέπει να συνδεθείτε πρωτα.")) {
		location.href="http://localhost/ge3/register.php";
	}
	</script>';
}
else if (!isset($_SESSION['centerAssignedFlag'])){
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Ο Χρήστης δεν έχει δηλώσει εμβολιαστικό κέντρο.")) {
		location.href="http://localhost/ge3/doctorLanding.php";
	}
	</script>';
}

$subpagetitle = "Προγραμματισμένα Ραντεβού Πολιτών";

$center = getCenterByCenterid($_SESSION['centerid']);
$bookedDates = getBookedDatesByCenterId($_SESSION['centerid']);

?>

<!DOCTYPE html>
<html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script type="text/javascript" src="js/helper.js"></script>
	<link rel="stylesheet" type="text/css" href="resources/doctorFormat.css" media="screen">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Πλατφόρμα εμβολιασμού - <?php echo $subpagetitle ?></title> 
</head>
<body id='body'>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<header class="p-3 bg-dark text-white">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="#" class="nav-link px-2 text-white"> ΜΕΝΟΥ ΡΑΝΤΕΒΟΥ </a></li>
				</ul>
			</div>
		</div>
	</header>
	<div class="p-5 py-4 mb-4 bg-light rounded-3">
		<div class="container-fluid">
			<div class="row">
				<div class='col-md-5'>
					<span class="fw-bold text-decoration-underline"><span id='centerName'></span></span><br>
					<span class="fw-bold"><span id='centerPhone'></span></span><br>
					<span class="fw-bold"><span id='centerAddress'></span></span><br>
					<span class="fw-bold"><span id='centertk'></span></span>
				</div>
				<div class="px-5 col-md-5 fw-bold">
					<div class="h-100 rounded-3">
						<a style="line-height: 2.5;" id="bookDate" class="btn btn-outline-secondary btn-dark btn-lg text-white" href='doctorLanding.php' role="button">Επιστροφή στην κεντρική σελίδα</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="p-5 py-4 mb-4 bg-light rounded-3" id="dates">
		<div class="container-fluid">
			<div class='col-md-12'>
				<div class="mytable1">
					<div>2022-04-01<br>Παρασκευή</div>
					<div>2022-04-02<br>Σάββατο</div>
				</div>
				<div class="between">
					<hr>
					<div>
						<div class="mytable2" id="mytable1" style="visibility:hidden;">
							<div class="" value="">08:00</div>
							<div class="" value="">08:00</div>
							<div class="" value="">09:00</div>
							<div class="" value="">09:00</div>
							<div class="" value="">10:00</div>
							<div class="" value="">10:00</div>
						</div>
					</div>
				</div>
			</div>
	<script type="text/javascript">
		let centerid = <?php echo $_SESSION['centerid'] ?> ;
		let bookedDates = <?php echo json_encode($bookedDates) ?> ;
		let vacdates = null;
		let center = <?php echo json_encode($center) ?> ;

		// εμφανίζει τα στοιχεια του εμβολιαστικού κέντρου δυναμικά
		document.getElementById('centerName').textContent = center['name'];
		document.getElementById('centerPhone').textContent = 'Τηλέφωνο: ' + center['phone'];
		document.getElementById('centerAddress').textContent =  'Διεύθυνση: ' + center['address'];
		document.getElementById('centertk').textContent =  'Τ.Κ.: ' + center['tk'];

		// θετουμε value attribute στα κελια των ραντεβου με τιμη ωρα
		// hardcoded επειδή είναι λίγα τα κελιά και σταθερές οι τιμές των ωρών 
		document.getElementById('mytable1').children[0].id = '2022-04-01;08:00';
		document.getElementById('mytable1').children[1].id = '2022-04-02;08:00';
		document.getElementById('mytable1').children[2].id = '2022-04-01;09:00';
		document.getElementById('mytable1').children[3].id = '2022-04-02;09:00';
		document.getElementById('mytable1').children[4].id = '2022-04-01;10:00';
		document.getElementById('mytable1').children[5].id = '2022-04-02;10:00';

		bookedDates.forEach((element) => {
			let div = document.getElementById(element['date'] + ';' + element['time']);
			    // assign correct color to indicate COMPLETED vs NOT COMPLETED VACCINATION
			    console.log(element.status)
			    if (element.status == 'ΜΗ ΟΛΟΚΛΗΡΩΜΕΝΟΣ') {
			    	div.className = 'notCompleted';
			    }
			    else {
			    	div.className = 'completed';	
			    }
			    div.id = element.uid;
			});
		
		bookedDates.forEach((element) => {
			fetch("http://localhost/ge3/php/getUserNameAMKA.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
				},
				body: `uid=${element.uid}`,
			})
			.then((response) => response.text())
			.then((response) => {
				let user = JSON.parse(response);
				let div = document.getElementById(user.uid);
				div.innerHTML = `
				<span>${user.firstname +' '+user.lastname}</span><br>
				<span>ΑΜΚΑ: ${user.amka} </span><br>
				<span>Κατάσταση Εμβολιασμού: ${element.status} </span><br>
				<a href='#' onclick="updateVacStatus(${element.vacdateid}, '${element.status}')" class="btn btn-outline-secondary btn-dark text-white mt-3">Αλλαγή Κατάστασης</a>`
			})
		});

		document.getElementById('mytable1').style.visibility = 'inherit';
		
	</script>
</body>
</html>'