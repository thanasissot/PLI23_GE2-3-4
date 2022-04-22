<?php 

// εκκκινηση του Session. γινεται ελεγχος αν ειναι χρήστης συνδεδεμενος αλλιως ξαναγυρναει στην αρχικη
// αντλουντε τα στοιχεια με του getUserByUid απο το dbController.php

session_start();
require "php/dbController.php";

if( ! isset($_SESSION['userLoggedIn'])) {
	echo '<script language="javascript" type="text/javascript">
	if (!alert ("ΣΦΑΛΜΑ. Για να εισέλθετε σε αυτή τη σελίδα πρέπει να συνδεθείτε πρωτα.")) {
		location.href="http://localhost/ge3/register.php";
	}
	</script>';
}
else {
    // το uid του current user
    $uid = $_SESSION['uid'];
    // επιστρεφει τα στοιχεια του χρηστη
    $userArray = getUserByUid($uid);
}

$age = $userArray['age'];
$vacdateArray = getVacDate($uid);

$_SESSION['vacdateid'] = '';
$vdate = '';
$vtime = '';
$centerid = '';
$cname = '';
$vacExists = 0;

if ($vacdateArray) {
    $_SESSION['vacdateid'] = $vacdateArray['vacdateid'];
    $vdate = $vacdateArray['vdate'];
    $vtime = $vacdateArray['vtime'];
    $centerid = $vacdateArray['vcenterid'];
    $cname = getCurrentCenterName($centerid);
    $vacExists = 1; 
} else {
    unset($_SESSION['vacdateid']);
}

$subpagetitle = "Κεντρική Σελίδα Χρήστη - Πολίτη";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script type="text/javascript" src="js/helper.js"></script>
    <?php echo "<title>Πλατφόρμα εμβολιασμού - $subpagetitle</title>"; ?>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <header class="p-3 bg-dark text-white">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="#" class="nav-link px-2 text-white fs-2 fw-bold"> Διεπαφή Πολίτη </a></li>
          </ul>
      </div>
  </div>
</header>
<div class="p-5 py-4 mb-4 bg-light rounded-3">
  <div class="container-fluid">
    <h4 class="fw-bold text-decoration-underline">Οι πληροφορίες σας:</h4>
    <div class='col-md-12'>
        <div class='table-responsive'>
            <table class='table table-user-information fw-bold'>
                <tbody>
                    <tr>        
                        <td>Όνομα</td>
                        <td>
                            <?php echo $userArray['firstname'] ?>     
                        </td>
                    </tr>
                    <tr>   
                        <td>Επώνυμο</td>
                        <td>
                            <?php echo $userArray['lastname'] ?>     
                        </td>
                    </tr>
                    <tr>    
                        <td>]Αριθμός Ταυτότητας</td>
                        <td>
                            <?php echo $userArray['pid'] ?>     
                        </td>
                    </tr>
                    <tr>        
                        <td>Α.Μ.Κ.Α</td>
                        <td >
                            <?php echo $userArray['amka'] ?>  
                        </td>
                    </tr>
                    <tr>        
                        <td>Α.Φ.Μ</td>
                        <td>
                            <?php echo $userArray['afm'] ?> 
                        </td>
                    </tr>
                    <tr>        
                        <td>Email</td>
                        <td>
                            <?php echo $userArray['email'] ?> 
                        </td>
                    </tr>
                    <tr>        
                        <td>Ήλικία</td>
                        <td>
                            <?php echo $userArray['age'] ?>
                        </td>
                    </tr>
                    <tr>        
                        <td>Τηλέφωνο</td>
                        <td >
                         <?php echo $userArray['phone'] ?>
                     </td>
                 </tr>
                 <tr>        
                    <td>Φύλο</td>
                    <td >
                     <?php echo $userArray['gender'] ?>
                 </td>
             </tr>
         </tbody>
     </table>
 </div>
</div>
</div>
</div>
<div class="row align-items-md-stretch px-2">
  <div class="col-md-6" id="vaccineCard">
    <div class="h-100 p-4 text-white bg-dark rounded-3">
      <h3 class="text-decoration-underline">Το Ραντεβού σας:</h3>
      <p class="fw-bold">
          Εμβολιαστικό Κέντρο : <?php echo $cname ?> <br>
          Ημερομηνία : <?php echo $vdate ?> <br>
          Ώρα : <?php echo $vtime ?>
      </p>
  </div>
</div>
<div class="px-5 col-md-4 fw-bold">
    <div class="h-100 rounded-3">
        <a style="line-height: 2.5;" id="bookDate" class="btn btn-outline-secondary btn-dark btn-lg text-white" href='#' onclick='bookVacDate(<?php echo $age ?>)' role="button">Κλείστε το ραντεβού σας</a>
        <a id="cancelDate" class="btn btn-outline-secondary btn-dark btn-lg text-white" href='#' onclick='confirmCancelDate()' role="button"> Ακυρώστε το ραντεβού σας </a>
        <a style="line-height: 2.5;" class="btn btn-outline-secondary btn-dark btn-lg text-white" href='php/logout.php' role="button"> Αποσύνδεση </a>
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
        font-weight: 700 !important;
    }
</style>
<script type="text/javascript">
    // καθε φορα που εμφανιζεται η σελιδα καλειται αυτη η συναρτηση
    // η οποία ελεγχει ποιο απο τα 2 section θα εμφανιστει αναλογα με το αν
    // ο χρηστης εχει ηδη καποιο ραντεβου ή οχι
    function vacInforOrCreateButton (vacDateBool){
        if (vacDateBool == 1) {
            document.getElementById('bookDate').style.display = 'none';
            document.getElementById('cancelDate').style.display = 'inline-block';
            document.getElementById('vaccineCard').style.display = 'block';
        }
        else {
            document.getElementById('cancelDate').style.display = 'none';
            document.getElementById('vaccineCard').style.display = 'none';
            document.getElementById('bookDate').style.display = 'inline-block';
        }
    };
    vacInforOrCreateButton(<?php echo $vacExists ?>);
</script>
</body>
</html>