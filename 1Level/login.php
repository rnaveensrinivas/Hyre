<?php
session_start() ; 

include '../config.php'; 

//If the user already signed in and trys to login.
if( isset($_SESSION['ID'])){
    header("location: ../mainlobby.php") ;
}

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
        $name=$row['name'];

        

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
        $_SESSION['name']=$name;
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
        <script src="validation.js"></script>
    </head>

    <body onload="newCaptcha()">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--navbar-expand aligns all components horizontally displayed-->
            <a class="navbar-brand ms-4" href="">Hyre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            <div class="collapse navbar-collapse" id="#navbarToggleButton">
              <ul class="navbar-nav px-4 ms-auto"> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
            </ul>
            <ul class="navbar-nav px-4"> <!--from documentation-->
              <li class="nav-item"><a class="nav-link" href="">Contact</a></li>
          </ul>
            <ul class="navbar-nav "> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="">Login</a></li>
            </ul>
            <ul class="navbar-nav px-4"> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="">Signup</a></li>
            </ul>
            </div>
        </nav>
        <form  action="" method="POST" autocomplete="off">
            <div class="form" style="margin-top:20px">

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

                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="margin-top:25px; border-radius:5px">New Captcha</button>
                <input type="text"  id="captcha" oncopy="return false" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" onpaste="return false" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <!-- Below validate captcha is not working. -->
                <button type="submit" onclick="return validCaptcha()" name="submit" id="submit-button" style="border-radius:5px;">Login</button>
                <p style="font-size :15px; " >New User ? <a href="signup.php" style="text-decoration:none; font-size: 15px;">Sign-Up</a></p>
                <!--
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
                </script> -->
            </div> 
        </form>
    </body>
</html>