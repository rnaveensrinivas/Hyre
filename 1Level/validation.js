function newCaptcha() {
    var alphabets = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ234567890'.split('');

    var a = alphabets[Math.floor(Math.random() * 58)];
    var b = alphabets[Math.floor(Math.random() * 58)];
    var c = alphabets[Math.floor(Math.random() * 58)];
    var d = alphabets[Math.floor(Math.random() * 58)];
    var e = alphabets[Math.floor(Math.random() * 58)];
    var f = alphabets[Math.floor(Math.random() * 58)];

    var captcha = a + b + c + d + e + f;

    document.getElementById('captcha').value = captcha;

}

function validationBooking(){

    var check = checkCaptcha() ; 
    var check2 = checkDate() ; 

    if( !check || !check2 ){
        return false ;
    }

    return true ;

}

function validationSignup(){
    var check = checkPassword() ;  
    var check2 = checkAge();
    var check3 = checkCaptcha() ; 
    //var check4 = checkLettersSpaces() ;

    if ( !check || !check2 || !check3 ) {
        return false;
    }
    return true ;
}

function checkCaptcha() {

    var captcha = document.getElementById('captcha').value;
    var enteredCaptcha = document.getElementById('enteredCaptcha').value;

    if (enteredCaptcha == '') {
        alert("Enter the captcha.");
        return false;
    }
    else if (captcha != enteredCaptcha) {
        alert("Wrong captcha Try again.");
        return false;
    }
    return true ;
}

function checkPassword() {

    var p1 = document.getElementById("pwd1").value;
    var p2 = document.getElementById("pwd2").value;

    if (p1 && p2) {
        if (p1 != p2) {
            alert("Passwords don't match");
            return false;
        }
        return true;
    }
    return false ;
}


function checkAge(){

    var userDateInput = document.getElementById("dOB").value;  
    
    var birthDate = new Date(userDateInput);

    /*
    var userYearInput = birthDate.getYear() ; 

    if(userYearInput <= 1900 ){
        alert('Enter a valid date of birth.') ; 
        return false ; 
    }
    */

    var difference=Date.now() - birthDate.getTime();
    
    var  ageDate = new Date(difference);
    
    var calculatedAge = Math.abs(ageDate.getUTCFullYear() - 1970);
    
    if(calculatedAge<18){
        alert("Age must be over 18");
        return false;
    }
    return true ;
}

function checkDate(){

    var userDateInput = document.getElementById("date").value;  

    var userDate = new Date(userDateInput);
    
    if( userDate < Date.now() ){
        alert("Enter valid date.");
        return false;
    }
    
    return true ;
}

/*
function checkLettersSpaces() {
    var str = document.getElementById('fname') ;
    if( /^[a-zA-Z\s]+$/.test(str) ){
        return true ; 
    }

    alert('Name should contain only uppercase , lowercase and spaces.') ;
    return false ;
}
*/