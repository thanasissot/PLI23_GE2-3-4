<?php

	if(session_id() == ''){
      session_start();
	}
	require "php/dbController.php";
?>
<!DOCTYPE html>

<html>
  <head>
  	  <!-- πληροφορίες για τη κωδικοποίηση της σελίδας για τους browsers -->
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
 	 <!-- O τίτλος που θα εμφανίζεται στα tabs του browser και πιθανο alert -->
     <?php
     		echo "<title>Πλατφόρμα εμβολιασμού - $subpagetitle</title>";
     ?>
	
	 <!-- Εισαγωγή του αρχείου CSS για χρήση σε οθόνη υπολογιστή-->
	 <link rel="stylesheet" type="text/css" href="resources/format.css" media="screen">
	 <script src="js/helper.js" type="text/javascript"></script><!--Έλεγχος πεδίων-->
  </head>

  <!-- Δημιουργία του header της σελίδας -->
  <header>
     <!-- Θα ορίσουμε έναν πίνακα μίας γραμμής με 3 στήλες που θα εκτείνεται σε όλο το μήκος -->
	 <!-- Όλες με κεντραρισμένο περιεχόμενο. Οι δύο ακρινές εκτείνονται στο 18% και η κεντρική στο 64% -->
	 <!-- Χωρίς κάτω περιθώριο γιατί θα φαίνεται διπλό μαζί με του κάτω πίνακα -->
	 <!-- Ορίζουμε και ένα minimum πλάτος για να μην συρρικνώνεται πολύ ή παραμορφώνεται όταν το παράθυρο μικραίνει -->
	 <table style="width:100% ; background-color: #d9d9d9; border-bottom: none; min-width: 1000px;">    <!-- χρώμα φόντου ίδιο με της εκφώνησης -->
	     <tr>
		 
		   <!-- Το πρώτο πεδίο περιέχει το λογότυπο που είναι και link προς την αρχική σελίδα -->
		   <td style="width:18%; text-align: center">
		       <!-- link τύπου <a> με μία τετράγωνη εικόνα png ρυθμισμένη να εμφανίζεται 140x140 pixel και ένα μικρό περιθώριο 5 pixel -->
			   <a href="index.php"> <img src="./pics/logo.png" alt="Αρχική σελίδα" style="width: 140px; height: 140px; margin: 5px" >  </a> 
		   </td>
	 
	       <!-- Το δεύτερο πεδίο περιέχει τη κεντρική επικεφαλίδα του site με μεγάλη γραμματοσειρά -->
		   <td style="width:64%; text-align: center; font-size:28px;">
		      <b>Πλατφόρμα εμβολιασμού</b>    <!-- Ο πρώτος τίτλος είναι bold-->
		      <br>                            <!-- Αλλαγή γραμμής και ο άλλος τίτλος-->
		      Υπουργείο Υγείας
		   </td> 
	  
	       <!-- Το τρίτο πεδίο είναι ένα κουμπί που οδηγεί στη σελίδα login/register -->
		   <!-- Απενεργοποιούμε την αναδίπλωση κειμένου στα κενά για να μη διπλώνει του κουμπί όταν το παράθυρο μικραίνει -->
	       <td class="button_area" style="width:18%; text-align: center;  white-space: nowrap;">
			   
	       	<?php 

	       		if(isset($_SESSION['userLoggedIn']) || isset($_SESSION['doctorLoggedIn'])) {
	       			echo "<a href='php/logout.php'> Αποσύνδεση </a>";
	       		}
	       		else {
	       			echo "<a href='register.php'> Είσοδος / Εγγραφή </a>";
	       		}

	       	?>
			   <br>
		   </td>
	 
	    </tr>
     </table>
  </header>

  <body>
     <!-- Θα ορίσουμε έναν πίνακα μίας γραμμής με 2 στήλες που θα εκτείνεται σε όλο το μήκος -->
	 <!-- και θα έχει default ύψος 600 pixel για να μη συρρικνώνεται πολύ όταν η δεξιά στήλη έχει λίγα data -->
	 <!-- Ορίζουμε και ένα minimum πλάτος για να μην συρρικνώνεται πολύ ή παραμορφώνεται όταν το παράθυρο μικραίνει -->
	 <table style="width:100% ; height: 600px ; min-width: 1000px;" >
	    <tr>
	    
		   <!-- Η πρώτη στήλη καταλαμβάνει 18% με το μενού στοιχισμένο στο κέντρο και προς τα πάνω -->
		   <!-- Εδώ βάζουμε χρώμα φόντου, ίδιο με της εκφώνησης, στη πρώτη στήλη γιατί η άλλη είναι λευκή -->
		   <td style="width:18%; text-align: center; vertical-align: top; background-color: #d9d9d9" >
		      <!-- Βάζουμε μία ετικέτα div για μορφοποίηση css ανεξάρτητα από τη στήλη πίνακα -->
			  <!-- Όχι ότι δε μπορεί να μπει στο td, αλλά είναι πιο ευανάγνωστο και ευκολότερο σε μελλοντικές αλλαγές -->
			  <!-- Τοποθετούμε όλα τα links του μενού, με το τρέχον να ανήκει στη κλάση trexon -->
		      <div class="menu" id="sidebar">  
			      <a href="index.php"> Αρχική σελίδα </a>
			      <a href="centers.php"> Εμβολιαστικά Κέντρα </a>
			      <a href="vacinfo.php"> Οδηγίες εμβολιασμού </a>
			      <a href="reginfo.php"> Οδηγίες εγγραφής / εισόδου </a>
			      <a href="announcements.php" > Ανακοινώσεις </a>
			  </div>
		   </td>