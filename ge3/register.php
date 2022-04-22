<?php

if(session_id() == ''){
      session_start();
}

if(isset($_SESSION['userLoggedIn']) || isset($_SESSION['doctorLoggedIn'])) {
	header("Location: index.php");
}


$subpagetitle = "Είσοδος / Εγγραφή";

// εισάγει τον κώδικα για το ανω μισό της σελίδας
include "views/boilerplate/boilerplate_head.php";

//  εισάγει τον κώδικα για το κομμάτι που είναι διαφορετικό αναλογα 
//  με την σελίδα που επισκεπτόμαστε στο WEB APP
include "views/html/register.html";

// εισάγει τον κώδικα για το υπολοιπο μισο της σελιδας
include "views/boilerplate/boilerplate_footer.php";


?>