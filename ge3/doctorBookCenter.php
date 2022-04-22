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
else {
    // το uid του current user
    $uid = $_SESSION['uid'];
    $centers = getAllCenters();

}

$subpagetitle = "Δήλωση εμβολιαστικού κέντρου";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script type="text/javascript" src="js/helper.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php echo "<title>Πλατφόρμα εμβολιασμού - $subpagetitle</title>"; ?>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <header class="p-3 bg-dark text-white">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 text-white fs-2 fw-bold" onclick="false"> Διεπαφή Γιατρού </a></li>
          </ul>
      </div>
  </div>
</header>
<div class="p-5 py-4 mb-4 bg-light rounded-3">
  <div class="container-fluid">
    <h4 class="fw-bold">Eπιλογή Εμβολιαστικού Κέντρου: </h4>
    <div class='col-md-12'>
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
<div class="row align-items-md-stretch px-2">
  <div class="col-md-6 col-sm-3" id="vaccineCard">
    <div class="h-100 rounded-3">
      <a class="btn btn-outline-secondary btn-dark btn-lg text-white" href='#' onclick='assingVacCenter(uid, centerid)'0 role="button"> Δήλωση Εμβολιαστικού Κέντρου </a>
      <a class="btn btn-outline-secondary btn-dark btn-lg text-white" href='doctorLanding.php' onclick='' role="button"> Επιστροφή στην κεντρική σελίδα </a>
  </div>
</div>
</div>
<style type="text/css">
    div > a {
        padding: 3px;
        margin-bottom: 10px;
        width: 277px;
        max-width: 277px;
        height: 79px;
        max-height: 79px;
    }
</style>
<script type="text/javascript">
    // make centers visible to Document, so onchange on select we make information appear dynamically
        let centers = <?php echo json_encode($centers); ?> ;
        let centerid = null;
        let uid = <?php echo $uid ?> ;
    // event listener καθε φορα που αλλαζει η τιμη απο το dropdown menu αλλαζουν και τα στοιχεια
        // του ΕΜβολιαστικου κεντρου καθως και εκτελειται η λογικη για τις διαθεσιμες ημερομηνιες
        document.getElementById('selectCenter').addEventListener('change', function(){
            centerid = document.getElementById('selectCenter').value;
            let index = centerid - 1; 
            document.getElementById('centerName').textContent = centers[index]['name'];
            document.getElementById('centerAddress').textContent =  'Οδός: ' + centers[index]['address'];
            document.getElementById('centerPhone').textContent = 'Τηλ: ' + centers[index]['phone'];
            document.getElementById('hide').style.visibility = 'inherit';
        });
</script>
</body>
</html>