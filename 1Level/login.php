<?php
session_start() ; 

include '../config.php'; 

if ( isset($_POST['submit'])){ 
    //Getting the form data.

    $phoneNumber = $conn->real_escape_string($_POST["phoneNumber"]) ; // Sanitizing upon arrival. 
    $pwd1 = $conn->real_escape_string($_POST["pwd1"]) ;
    $pwd1 = md5($pwd1); 

    //query the database. 
    $resultSet = $conn->query("SELECT * FROM account WHERE phoneNumber = '$phoneNumber' AND password = '$pwd1' LIMIT 1") ; 
    
    if( $resultSet->num_rows ){ 
        //Process Login. 
        $row = $resultSet->fetch_assoc() ; 
        $accountStatus = $row['accountStatus'] ; 
        $ID = $row['ID'] ; 
        $userType = $row['userType'] ;

        //$em_database = $row['Email'] ; 
        //$CollegeID = $row['CollegeID'] ; 
        //$Password1 = $row['Password1'] ; 
        //$createdDate = $row['CreatedDate'] ;
        //$Category = $row['Category'] ; 
        //$FullName = $row['FullName'] ;  

        //$_SESSION['CollegeID'] = $CollegeID ;
        //$_SESSION['Password1'] = $Password1 ; 
        //$_SESSION['FullName'] = $FullName ;   
        //$_SESSION['Category'] = $Category ;
        $_SESSION['ID'] = $ID ; 
        $_SESSION['userType'] = $userType ;

    
        if ( $accountStatus == 1 ){ // if it is a verifed account.
            header('location:../mainlobby.php');
        }
        else  if ( $accountStatus == 0 ){ 
            //$error .= "This account needs to be verified.<br>Mail: '$em_database'<br>Date Created : '$createdDate'. "; 
            $error .= "This account needs to be verified.<br>";
        }
        else{ 
            //$error .= "This account needs to be verified.<br>Mail: '$em_database'<br>Date Created : '$createdDate'. "; 
            $error .= "This account has been disabled. Go to contact page and apporach the team.<br>";
        }
    }
    else{
        $error .= "Invalid Username or password. Try Again. " ; 
    }
}
$conn->close() ; 
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="darkTheme.css">
        <script src="validation.js"></script>
    </head>

    <body onload="newCaptcha()">
        <form  action="" method="POST" autocomplete="off">
            <div class="form">

                <h2>(to be filled)</h2>
                <p>(to be filled)</p>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>
            
                <div class="email">
                    <label for="phoneNumber">Phone Number</label><br>
                    <input type = "number" id="phoneNumber" name="phoneNumber" required><br>
                </div>
      
                <label for="pwd1">Password</label><br>
                <input type="password" id="pwd1" name="pwd1" minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.]" required >
                <!--<a href="resetpassword.php" style="text-decoration:none; font-size: 15px;">Forgot Password?</a><br><br> -->

                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
                <input type="text"  id="captcha" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <!-- Below validate captcha is not working. -->
                <button type="submit" onclick="return validCaptcha()" name="submit" id="submit-button">Login</button>
                <p style="font-size :15px; " >New User ? <a href="signup.php" style="text-decoration:none; font-size: 15px;">Sign-Up</a></p>

                <script>
                    function validCaptcha(){ 
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
                </script>
            </div> 
        </form>
    </body>
</html>