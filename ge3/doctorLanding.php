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
    // επιστρεφει τα στοιχεια του χρηστη
    $userArray = getUserByUid($uid);
    // επιστρεφει εμβολιαστικο κεντρο αν εχει ανατεθεί
    $centerid = getVacCenterIdByDoctorId($uid);
    $centerAssignedFlag = 'false';
    if (isset($centerid)) {
        $centerAssignedFlag = 'true';
        $_SESSION['centerAssignedFlag'] = $centerAssignedFlag;
        $_SESSION['centerid'] = $centerid;
    }
    else {
        unset($_SESSION['centerAssignedFlag']);
        unset($_SESSION['centerid']);
    }
    
}



$subpagetitle = "Κεντρική Σελίδα Χρήστη - Γιατρού";

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
                <li><a href="#" class="nav-link px-2 text-white fs-2 fw-bold" onclick="false"> Διεπαφή Γιατρού </a></li>
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
  <div class="col-md-6 col-sm-3" id="vaccineCard">
    <div class="h-100 rounded-3">
      <a class="btn btn-outline-secondary btn-dark btn-lg text-white" 
        href='doctorBookCenter.php' 
        onclick='return checkFlag(<?php echo $centerAssignedFlag ?>, 0)' 
        role="button"> Δήλωση Εμβολιαστικού Κέντρου </a>

      <a class="btn btn-outline-secondary btn-dark btn-lg text-white" 
        href='doctorViewDates.php' 
        onclick='return checkFlag(<?php echo $centerAssignedFlag ?>, 1)' 
        role="button"> Προγραμματισμένα Ραντεβού </a>

      <a style="line-height: 2.5;" 
        class="btn btn-outline-secondary btn-dark btn-lg text-white" 
        href='php/logout.php' 
        role="button"> Αποσύνδεση </a>
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

</script>
</body>
</html>