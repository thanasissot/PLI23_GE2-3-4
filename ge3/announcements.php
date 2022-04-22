<?php

$subpagetitle = "Ανακοινώσεις";

// εισάγει τον κώδικα για το ανω μισό της σελίδας
include "views/boilerplate/boilerplate_head.php";

//  εισάγει τον κώδικα για το κομμάτι που είναι διαφορετικό αναλογα 
//  με την σελίδα που επισκεπτόμαστε στο WEB APP
include "views/html/announcements.html";

// εισάγει τον κώδικα για το υπολοιπο μισο της σελιδας
include "views/boilerplate/boilerplate_footer.php";

?>