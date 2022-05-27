function newCaptcha(){ 
    var alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'.split('');

    var a = alphabets[ Math.floor(Math.random()* 62) ];
    var b = alphabets[ Math.floor(Math.random()* 62) ]; 
    var c = alphabets[ Math.floor(Math.random()* 62) ]; 
    var d = alphabets[ Math.floor(Math.random()* 62) ]; 
    var e = alphabets[ Math.floor(Math.random()* 62) ];
    var f = alphabets[ Math.floor(Math.random()* 62) ];

    var captcha = a + b + c + d + e + f; 

    document.getElementById('captcha').value = captcha ; 
     
}

function validCaptcha(){ 

    var check = checkPassword() ; // application of stack. 
    if (!check ){ 
        return false ; 
    }

    var captcha = document.getElementById('captcha').value ; 
    var enteredCaptcha = document.getElementById('enteredCaptcha').value ; 

    if( enteredCaptcha == '' ){ 
        alert("Enter the captcha.") ; 
        return false ; 
    }
    else if( captcha != enteredCaptcha ){ 
        alert("Wrong captcha Try again.") ; 
        return false ; 
    }
}

function checkPassword() {
    
    var p1 = document.getElementById("pwd1").value;
    var p2 = document.getElementById("pwd2").value;

    if( p1 && p2 ){ 
        if(p1 != p2) {
            alert("Passwords don't match");
            return false ; 
        }
        return true ;
    }
    else{ 
        return false ; 
    }
     
}