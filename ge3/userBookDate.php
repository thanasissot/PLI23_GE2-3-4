<?php
session_start();
require "php/dbController.php";

if( ! isset($_SESSION['userLoggedIn'])) {
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Για να εισέλθετε σε αυτή τη σελίδα πρέπει να συνδεθείτε πρωτα.")) {
		location.href="http://localhost/ge3/register.php";
	}
	</script>';
}
else if (isset($_SESSION['vacdateid'])){
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Ο Χρήστης έχει ήδη προγραμματίσει ραντεβού.")) {
		location.href="http://localhost/ge3/userLanding.php";
	}
	</script>';
}

$subpagetitle = "Προγραμματισμός Ραντεβού";

$centers = getAllCenters();

?>

<!DOCTYPE html>
<html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script type="text/javascript" src="js/helper.js"></script>
	<link rel="stylesheet" type="text/css" href="resources/userFormat.css" media="screen">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Πλατφόρμα εμβολιασμού - <?php echo $subpagetitle ?></title> 
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<header class="p-3 bg-dark text-white">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="#" class="nav-link px-2 text-white"> ΠΡΟΓΡΑΜΜΑΤΙΣΜΟΣ ΡΑΝΤΕΒΟΥ </a></li>
				</ul>
			</div>
		</div>
	</header>
	<div class="p-5 py-4 mb-4 bg-light rounded-3">
		<div class="container-fluid">
			<div class='row'>
				<h4 class="fw-bold">Eπιλογή Εμβολιαστικού Κέντρου: </h4>
				<div class='col-md-6'>
					<select name="center" id="selectCenter" style="float: left; width: 360px; font-size: 1.2em;">
						<option disabled selected value> -- Επιλογή -- </option>
						<?php 
						for ($i = 0; $i < count($centers); $i++) {
							$centerNameC = $centers[$i]['name'];
							$centerid = $centers[$i]['centerid'];
							echo "<option value=$centerid>$centerNameC</option>";
						}
						?>
					</select>
				</div>
				<div class="px-5 col-md-5 fw-bold">
					<div class="h-100 rounded-3">
						<a style="line-height: 2.5;" id="bookDate" class="btn btn-outline-secondary btn-dark btn-lg text-white" href='userLanding.php' role="button">Επιστροφή στην κεντρική σελίδα</a>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="p-5 py-4 mb-4 bg-light rounded-3">
		<div class="container-fluid">
			<div class='col-md-12' id='hide' style="visibility: hidden;">
				<span class="fw-bold"><span id='centerName'></span></span><br>
				<span class="fw-bold">Διεύθυνση : <span id='centerAddress'></span></span> <br>
				<span class="fw-bold">Τηλέφωνο : <span id='centerPhone'></span></span>
			</div>
		</div>
	</div>
	<div class="p-5 py-4 mb-4 bg-light rounded-3" style="visibility: hidden;" id="dates">
		<div class="container-fluid">
			<div class='col-md-12' id='hide'>
				<div class="mytable1">
					<div>2022-04-01<br>Παρασκευή</div>
					<div>2022-04-02<br>Σάββατο</div>
				</div>
				<div class="between">
					<hr>
				</div>
				<div class="mytable2" id="mytable1">
					<a class="" value="" href='#' onclick="confirmBookDate(this.id, this.disabled, centerId)">08:00</a>
					<a class="" value="" href='#' onclick="confirmBookDate(this.id, this.disabled, centerId)">08:00</a>
					<a class="" value="" href='#' onclick="confirmBookDate(this.id, this.disabled, centerId)">09:00</a>
					<a class="" value="" href='#' onclick="confirmBookDate(this.id, this.disabled, centerId)">09:00</a>
					<a class="" value="" href='#' onclick="confirmBookDate(this.id, this.disabled, centerId)">10:00</a>
					<a class="" value="" href='#' onclick="confirmBookDate(this.id, this.disabled, centerId)">10:00</a>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">
		// make centers visible to Document, so onchange on select we make information appear dynamically
		let centers = <?php echo json_encode($centers); ?> ;
		let vacdates = null;
		let centerId = null;
		// θετουμε value attribute στα κελια των ραντεβου με τιμη ημερομηνια-ωρα.
		// γινεται hardcoded και οχι αυτοματα λογω των περιορισμων της ασκησης μονο σε 2 μερες και 3 διαθεσιμες ωρες
		let dateCells = document.getElementById('mytable1').children;
		for (let i = 0; i < dateCells.length; i+=2) {
			dateCells[i].id = '2022-04-01;' + dateCells[i].textContent;
			dateCells[i+1].id = '2022-04-02;' + dateCells[i].textContent;
		}
		
		// event listener καθε φορα που αλλαζει η τιμη απο το dropdown menu αλλαζουν και τα στοιχεια
		// του ΕΜβολιαστικου κεντρου καθως και εκτελειται η λογικη για τις διαθεσιμες ημερομηνιες
		document.getElementById('selectCenter').addEventListener('change', function(){
			centerId = document.getElementById('selectCenter').value;
			let index = centerId - 1; 
			document.getElementById('centerName').textContent = centers[index]['name'];
			document.getElementById('centerAddress').textContent =  'Οδός: ' + centers[index]['address'];
			document.getElementById('centerPhone').textContent = 'Τηλ: ' + centers[index]['phone'];
			document.getElementById('hide').style.visibility = 'inherit';	

			
			// επιστρεφουμε και ολες τις δεσμευμενες ημερομηνιες για το συγκεκριμενο vac center
			// μεσω POST REQUEST απο τον Browser προς το αρχει0 getVaccines.php θετοντας στο body του request
			// καταλληλα την παραμετρο που χρειαζεται για να κανει query στη ΒΔ
			fetch("http://localhost/ge3/php/getVaccines.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
				},
				body: `centerid=${centerId}`,
			})
			.then((response) => response.text())
			.then((res) => {
				vacdates = JSON.parse(res);
				document.getElementById('dates').style.visibility = 'inherit';
				// unset previous settings for cells
				let dateCells1 = document.getElementById('mytable1').children;
				for (let i = 0; i < dateCells.length; i++) {
					dateCells[i].className = '';
					dateCells[i].disabled = false;
				}
			    // set the proper styles according to available/unavailable dates
			    vacdates.forEach((element) => {
			    	let div = document.getElementById(element['date'] + ';' + element['time']);
			    	div.disabled = true;
			    	div.className = 'disabled';
			    	div.onclick = 'return false'
			    });
			  });

		});

	</script>
</body>