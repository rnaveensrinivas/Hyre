<?php
session_start() ; 

include '../config.php'; 

//If the user already signed in and trys to login.
if( isset($_SESSION['ID'])){
    header("location: ../mainlobby.php") ;
}

//Getting the form data.
if ( isset($_POST['submit'])){ 
    
    $phoneNumber = $_POST["phoneNumber"] ; 
    $pwd1 = md5($_POST["pwd1"]) ; //getting and encrypting the password.

    //Query for checking if phone Number and password exist.
    $isExistingAccountQuery = "SELECT * FROM account WHERE phoneNumber = '$phoneNumber' AND password = '$pwd1' LIMIT 1" ;
    $resultSet = $conn->query($isExistingAccountQuery) ; 
    
    if( $resultSet->num_rows ){ 
        //Account Exists.

        $row = $resultSet->fetch_assoc() ; 

        $_SESSION['name']=$row['name'];
        $_SESSION['ID'] = $row['ID'] ; 
        $_SESSION['userType'] = $row['userType'] ;
        $accountStatus = $row['accountStatus'] ; 

        if ( $accountStatus == 1 ){ // if it is a verifed account.
            header('location:../mainlobby.php');
        }
        else  if ( $accountStatus == 0 ){ 
            $error .= "This account needs to be verified.<br>";
        }
        else{ 
            $error .= "This account has been disabled. Go to contact page and apporach the team.<br>";
        }
    }
    else{
        $error .= "Invalid Username or password. Try Again." ; 
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    </head>

    <body onload="newCaptcha()">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--navbar-expand aligns all components horizontally displayed-->
            <a class="navbar-brand ms-4" href="../index.html">Hyre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            <div class="collapse navbar-collapse" id="navbarToggleButton">
              
            <ul class="navbar-nav px-4 ms-auto"> <!--from documentation-->
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
          </ul>
            
            <ul class="navbar-nav px-4"> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="signup.php">Signup</a></li>
            </ul>
            </div>
        </nav>
        <form  action="" method="POST" autocomplete="off">
           <div class="form" style="margin-top:20px">
 
                <h2>Login</h2>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>
            
                <div class="email">
                    <label for="phoneNumber">Phone Number</label><br>
                    <input type = "number" id="phoneNumber" name="phoneNumber" min=1000000000 max=9999999999 required><br>
                </div>
      
                <label for="pwd1">Password</label><br>
                <input type="password" id="pwd1" name="pwd1" minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.]" required >

                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="margin-top:25px; border-radius:5px">New Captcha</button>
                <input type="text"  id="captcha" oncopy="return false" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" onpaste="return false" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <button type="submit" onclick="return checkCaptcha()" name="submit" id="submit-button" style="border-radius:5px;">Login</button>
                <p style="font-size :15px; " >New User ?<a href="signup.php" style="text-decoration:none; font-size: 15px;">Sign-Up</a></p>

            </div> 
        </form>
    </body>
</html>