//Έλεγχος σύνδεσης
/*Συνάρτηση με την οποία γίνεται έλεγχος τωνς στοιχείων που έδωσε ο χρήστης μέσω της φόρμας loginform*/
function validateLogin() {

    var amka = document.forms["loginform"]["amka"].value;
    var afm = document.forms["loginform"]["afm"].value;
    
    // ελεγχος ΑΜΚΑ
    if (/\D/.test(amka) || amka.length != 11) {
        alert("Το Α.Μ.Κ.Α. πρεπει να αποτελειται μονο απο αριθμητικούς χαρακτήρες και να έχει μήκος 11");
        return false;
    }

    // ελεγχος ΑΦΜ
    else if (/\D/.test(afm) || afm.length != 9) {
        alert("Το Α.Φ.Μ. πρεπει να αποτελειται μονο απο αριθμητικούς χαρακτήρες και να έχει μήκος 9");
        return false;
    }

    return true;
}

//Έλεγχος εγγραφής
/*Συνάρτηση με την οποία γίνεται έλεγχος τωνς στοιχείων που έδωσε ο χρήστης μέσω της φόρμας registerform*/
function validateRegister() {

    let firstname = document.forms["registerform"]["firstname"].value;
    let lastname = document.forms["registerform"]["lastname"].value;
    let amka = document.forms["registerform"]["amka"].value;
    let afm = document.forms["registerform"]["afm"].value;
    let pid = document.forms["registerform"]["pid"].value;
    let age = document.forms["registerform"]["age"].value;
    let phone = document.forms["registerform"]["phone"].value;
    let email = document.forms["registerform"]["email"].value;

    if (firstname.length == 0 || lastname.length == 0 || amka.length == 0 || afm.length == 0 || 
        pid.length == 0 || age.length == 0 || phone.length == 0) {
        alert("Τα υποχρεωτικα πεδια δεν μπορει να είναι κενά");
        return false;
    }

    // ελεγχος email
    else if (!(/\S+@\S+\.\S+/.test(String(email).toLowerCase())) && email.length > 0) {
        alert("Το E-mail δεν έχει σωστή μορφή!");
        return false;
    }

    // ελεγχος ΑΜΚΑ
    else if (/\D/.test(amka) || amka.length != 11) {
        alert("Το Α.Μ.Κ.Α. πρεπει να αποτελειται μονο απο αριθμητικούς χαρακτήρες και να έχει μήκος 11");
        return false;
    }

    // ελεγχος ΑΦΜ
    else if (/\D/.test(afm) || afm.length != 9) {
        alert("Το Α.Φ.Μ. πρεπει να αποτελειται μονο απο αριθμητικούς χαρακτήρες και να έχει μήκος 9");
        return false;
    }

    // ελεγχος αριθμού ταυτοτητας. για απλοτητα θα συμπεριλαβουμε μονο 
    // αριθμους πολιτικης ταυτοτητας με μορφη ΑΒ-123456
    else if (!(/^\w{2}(-| ){0,1}\d{6}/.test(pid)) && !(/^\W{2}(-| ){0,1}\d{6}/.test(pid))) {
        alert("Ο αριθμος ταυτότητας είναι λάθος. " + 
            " Πρεπει να έχει τη μορφή ΑΒ-123456 ή ΑΒ 123456 ή ΑΒ123456");
        return false;
    }

    return true;
}