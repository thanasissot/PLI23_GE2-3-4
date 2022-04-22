// κανει Active στο Sidebar το αντιστοιχο κουμπι αναλογα με τον τιτλο σελίδας 
// κανουμε χειροκινητα MAP ποιο index απο τα inner <a> elements του menu bar
/* indexes
    0 - Αρχική Σελίδα - index
    1 - Εμβολιαστικά Κέντρα - centers
    2 - Οδηγίες εμβολιασμού - vacinfo
    3 - Οδηγίες εγγραφής / εισόδου - reginfo
    4 - Ανακοινώσεις - announcements

    */
    function setActiveClass (index) {
        const sidebar = document.getElementById("sidebar").querySelectorAll("a");
        sidebar[index].className = "trexon";
}

// εκτελειται οταν ο χρηστης παταει το κουμπι Ακυρωστε το ραντεβου σας
// ζηταει επιβεβαιωση απο το χρηστη. Αν ο χρηστης πατησει ΝΑΙ τοτε
// η ροη τους προγραμματος μεταφερεται στο cancel.php το οποιο χειριζεται τη διαγραφη
function confirmCancelDate() {
    if (confirm("Είστε σίγουρος/η ότι επιθυμείτε να ακυρώσετε το ραντεβού σας;")){
        window.location = './php/cancel.php';
    }
}

// εκτελειται οταν ο χρηστης παταει το κουμπι Κλειστε ενα ραντεβου
// ελεγχει αν ο χρηστης ανηκει στη σωστη ηλικιακη ομαδα. αν ναι κανει redirect
function bookVacDate(age) {
    if (age < 40 || age > 65) {
        alert('Αυτη τη χρονική περίοδο ο προγραμμτισμός ραντεβού για εμβολιασμό είναι διαθέσιμος'
         + ' μονο στην ηλικιακή ομάδα των 40 - 65 ετών.');
    }
    else {
        window.location = './userBookDate.php';
    }
}

// εκτελειται οταν ο χρηστης/Πολίτης παταει κλικ πανω σε μια επιλογη απο τα διαθεσιμα ραντεβου
// οπου του ζητειται επιβεβαιωση και αν πατησει ΝΑΙ/YES γινεται η κλήση της insertVacDate.php
// στο backend που περιεχει τη λογικη για την εισαγωγη του ραντεβου στη ΒΔΔ
function confirmBookDate(clickedID, disabled, centerId) {
    if (!disabled) {
        if (confirm('Είστε σίγουρος/η ότι επιθυμείτε να κλεισετε αυτην την μερα και ώρα;')) {
            let date = clickedID.split(';')[0];
            let time = clickedID.split(';')[1];
            $.ajax({
                        type : "POST",  //type of method
                        url  : "http://localhost/ge3/php/insertVacDate.php",
                        data : { centerId : centerId, date : date, time : time },
                        success: function(res){
                            if(res == 'true') {
                                alert('Η δήλωση του ραντεβού πραγματοποιήθηκε επιτυχώς!');
                                location.href = './userLanding.php';                
                            }
                            else {
                                alert('Η δήλωση του ραντεβούΔΕΝ πραγματοποιήθηκε.');
                            }
                        }
                    });
        }
    } 
}


// ελεγχει αν η δηλωση του εμβολιαστικου κεντρου εχει πραγματοποιηθει ετσι ωστε ο Χρηστης/Γιατρος 
// να προχωρησει ειτε στη δήλωση εμβολιαστικου κέντρου ή οχι
// επίσης χρησιμοποιειται για τον ιδιο έλεγχο αλλα οταν ο χρηστης/Γιατρος προσπαθει να μεταβεί στα 
// προγραμματισμενα ραντεβού. δεν μπορει αν δεν εχει δηλωσει Εμβολιαστικο κέντρο. Εμφανιζεται το αντιστοιχο μηνυμα
function checkFlag(isCenterAssigned, index) {
    if (isCenterAssigned && index == 0) {
        alert('Η δήλωση του εμβολιαστικού κέντρου έχει ήδη πραγματοποιηθεί!');
        return false;
    }

    if (!isCenterAssigned && index == 1) {
        alert('Η δήλωση του εμβολιαστικού κέντρου ΔΕΝ έχει πραγματοποιηθεί!');
        return false;
    }

    return true;
}


// επιτρεπει στον γιατρό να δηλώσει εμβολιαστικό κέντρο
function assingVacCenter(uid, centerid) {
    if(centerid === null) {
        alert('Πρεπει να επιλεξετε ενα εμβολιαστικό κέντρο πρώτα!')
        return false;
    }

    if (confirm('Είστε σίγουρος/η ότι θέλετε να επιλεξετε αυτο το εμβολιαστικό κέντρο;')) {
        $.ajax({
                type : "POST",  //type of method
                url  : "http://localhost/ge3/php/insertDoctorRecord.php",
                data : {  uid : uid , centerid : centerid },
                success: function(res){
                    if(res == 'true') {
                        alert('Η δήλωση του εμβολιαστικού κέντρου πραγματοποιήθηκε επιτυχώς!');
                        location.href = './doctorLanding.php';                    
                    }
                    else {
                        alert('Η δήλωση του εμβολιαστικού κέντρου ΔΕΝ πραγματοποιήθηκε.');
                    }
                }
            });
    }
}

// επιτρέπει στον γιατρό να αλλάξει την κατάσταση εμβολιασμού ενός ασθενή
function updateVacStatus(vacdateid, status) {
    if (confirm('Είστε σίγουρος/η ότι θέλετε να αλλάξετε την κατάσταση εμβολιασμού;')) {
        $.ajax({
                type : "POST",  //type of method
                url  : "http://localhost/ge3/php/updateVacStatus.php",
                data : {  vacdateid : vacdateid , status : status },
                success: function(res){
                    if(res == 'true') {
                        alert('Η αλλαγή της κατάστασης πραγματοποιήθηκε επιτυχώς');
                        location.href = './doctorViewDates.php';                    
                    }
                    else {
                        alert('Η αλλαγή της κατάστασης δεν πραγματοποιήθηκε.');
                    }
                }
            });
    }
}
