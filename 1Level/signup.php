<?php
session_start() ;
include '../config.php';

if( isset($_SESSION['ID'])){ //If the user already signed in and trys to signup.
  header("location: ../mainlobby.php") ;
}

if( isset($_POST['submit'])){ //Checking if the form is submitted. 

  $phoneNumber = $_POST["phoneNumber"];
  $aadhaar = $_POST["aadhaar"];
  $pwd1 = $_POST["pwd1"]; 
  $pincode=$_POST["pincode"];

  $checkPincodeIfExists = "SELECT * from tamilnadupincodes where pincode = '$pincode'" ; 
  $checkPhoneNumberIfExistsQuery = "SELECT * FROM account WHERE phoneNumber = '$phoneNumber'" ; //Checking if phone already exists. 
  $checkAadhaarIDIfExistsQuery = "SELECT * FROM account WHERE aadhaar = '$aadhaar'" ; //Checking if aadhaar ID already exists. 
  $pincodeResult = mysqli_query( $conn , $checkPincodeIfExists ) ;
  $phoneNumberResult = mysqli_query( $conn , $checkPhoneNumberIfExistsQuery ) ; 
  $aadhaarIDResult =  mysqli_query( $conn , $checkAadhaarIDIfExistsQuery ) ; 


  if( $phoneNumberResult->fetch_assoc()){
    echo "<script>alert('This Phone Number already exists. Go to login page.')</script>" ; 
  }
  else if( $aadhaarIDResult->fetch_assoc()){
    echo "<script>alert('This Aadhaar ID Id already exists. Go to login page.')</script>" ; 
  }
  else if( $pincodeResult->fetch_assoc()){

    //Getting rest of the details here. 
    $fname=$_POST["fname"];
    $gender=$_POST["gender"] ;
    $dOB=$_POST["dOB"];
    $userType=$_POST["userType"];
    

    $pwd1 = md5($pwd1) ; 
    $ID = md5($aadhaar) ; 
      
    $insertQuery = "INSERT INTO account(name,phoneNumber,gender,dOB,pincode,aadhaar,password,userType,ID,accountStatus,reportCount) VALUES ('$fname','$phoneNumber','$gender','$dOB','$pincode','$aadhaar','$pwd1','$userType','$ID',1,0)";

    if ($conn->query($insertQuery)){ 

      if( $userType == "C" ){
        $conn->query("INSERT INTO client(clientID) values('$ID') ") ;
      }
      else{
        $conn->query("INSERT INTO worker(workerID) values('$ID') ") ;
      }
      echo "<script>alert('Account successfully created.')</script>";
      header('location:thankyou.php?Status=success');
    }  
  }
  else{ 
    echo "<script>alert('This pincode is not in Tamil Nadu')</script>" ; 
  }
  $conn->close();
}


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="darkTheme.css">
   
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
    <script src="validation.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


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
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            </ul>
            
            </div>
        </nav>
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>Sign Up</h2>
            
        <div class="fname">
          <label for="fname">Full Name</label><br>
          <input type = "text" id="fname" name="fname" placeholder="Eg: Rithvik Senthil" required><br>
        </div>

        <label for="phoneNumber">Phone Number</label><br>
        <input type = "text" id="phoneNumber" name="phoneNumber" placeholder="Eg: 73328 09723" required ><br>
        
        <div style="text-align:center; padding:10px;">
          Gender:
          <div style="padding:5px; display:inline">
            <input type="radio" name="gender" id="male" value="M" required>
            <label for='male'>Male</label>
          </div>
          
          <div style="padding:5px; display:inline">
            <input type="radio" name="gender" id="female" value="F">
            <label for='female'>Female</label>
          </div>
        </div>

        <div style="text-align:center; padding:10px;">
          User Type:
          <div style="padding:10px; display:inline">
            <input type="radio" name="userType" id="worker" value="W" required>
            <label for='worker'>Worker</label>
          </div>
          
          <div style="padding:10px; display:inline">
            <input type="radio" name="userType" id="client" value="C">
            <label for='client'>Client</label><br>
          </div>
        </div>
            
        <label for="dOB">Date Of Birth</label><br>
        <input type="date" id="dOB" name="dOB" required ><br>

        <label for="pincode">Pincode</label><br>
        <input type="number" id="pincode" name="pincode" min="100000" max="999999" placeholder="Eg: 600025" required><br>
    
        <label for="aadhaar">Aadhaar ID</label><br>
        <input type="number" id="aadhaar" name="aadhaar" min="1000000000000000" max="9999999999999999" placeholder="Eg: 2567 7765 8586 5650" required><br>

        <label for="pwd1">Password</label><br>
        <input type="password" id="pwd1" name="pwd1"  minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters" required><br>

        <label for="pwd2">Confirm Password</label><br>
        <input type="password" id="pwd2" name="pwd2"  minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters" required><br><br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
        <input type="text"  id="captcha" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
        
        <button type="submit" onclick="return validationSignup()" name="submit" id="submit-button">Create Account</button>
        <p style="font-size :15px; " >Already a user ? <a href="login.php" style="text-decoration:none; font-size: 15px;">Login</a></p>
        

      </div> 
    </form>
  </body>
</html>