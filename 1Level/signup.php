<?php
include '../config.php';

if( isset($_POST['submit'])){ //Checking if the form is submitted. 

  $phoneNumber = $_POST["phoneNumber"];
  $aadhaar = $_POST["aadhaar"];
  $pwd1 = $_POST["pwd1"]; 
  $pwd2 = $_POST["pwd2"];

  $checkPhoneNumberIfExists = "SELECT * FROM account WHERE phoneNumber = '$phoneNumber'" ; //Checking if phone already exists. 
  $checkAadhaarIDIfExists = "SELECT * FROM account WHERE aadhaar = '$aadhaar'" ; //Checking if aadhaar ID already exists. 
  $phoneNumberResult = mysqli_query($conn , $checkPhoneNumberIfExists) ; 
  $aadhaarIDResult =  mysqli_query($conn , $checkAadhaarIDIfExists) ; 


  if( $phoneNumberResult->fetch_assoc()){
    echo "<script>alert('This Phone Number already exists. Go to login page.')</script>" ; 
  }
  else if( $aadhaarIDResult->fetch_assoc()){
    echo "<script>alert('This Aadhaar ID Id already exists. Go to login page.')</script>" ; 
  }
  else if( $pwd1 != $pwd2 ){ 
    echo "<script>alert('Passwords do not match.')</script>";
  }
  else{    //Server Side validation is done. 

    //Getting rest of the details here. 
    $fname=$_POST["fname"];
    $gender=$_POST["gender"] ;
    $dOB=$_POST["dOB"];
    $userType=$_POST["userType"];
    $pincode=$_POST["pincode"];

    //sanitize form data. - removes all illegal form data.
    $phoneNumber= $conn->real_escape_string($phoneNumber);
    $fname=$conn->real_escape_string($fname);
    $aadhaar=$conn->real_escape_string($aadhaar);
    $gender=$conn->real_escape_string($gender);
    $userType=$conn->real_escape_string($userType);
    $pincode=$conn->real_escape_string($pincode);
    $dOB=$conn->real_escape_string($dOB);
    $pwd1=$conn->real_escape_string($pwd1); 
      
    //encrypting the password. 
    $pwd1 = md5($pwd1) ; //md5() is an encrypting function. 

    //generate ID
    $ID = md5($aadhaar) ; 
      
    $insert = "INSERT INTO account(name,phoneNumber,gender,dOB,pincode,aadhaar,password,userType,ID,accountStatus,reportCount) VALUES ('$fname','$phoneNumber','$gender','$dOB','$pincode','$aadhaar','$pwd1','$userType','$ID',0,0)";

    if ($conn->query($insert)) { 

      if( $userType == "C" ){
        $conn->query("INSERT INTO client( clientID) values('$ID') ") ;
      }
      else{
        $conn->query("INSERT INTO worker( workerID ) values('$ID') ") ;

      }
      echo "<script>alert('Account successfully created. Click Ok to login.')";
      /*
      //Sending Email Verification.
    
      $to = $em ; 
      $subject = "Account Verification." ; 
      // I am sending $vkey along with the page in mail.
      $message = "<p> Hi thanks for signing up with Eduvate to Verify your account please click <a href='http://localhost/Eduvate-app/1Level/verifiedpage.php?Vkey=$Vkey'>Here</a></p>" ; 
      $headers = "From: appeduvate@gmail.com \r\n" ; //App i am send form. 
      $headers .= "MIME-Version: 1.0" . "\r\n" ; // \r - return carriage || \n - newline 
      $headers .= "Content-type:text/html;charset=UTF-8". "\r\n" ; 

      mail($to , $subject , $message, $headers) ; 
      */
      header('location:thankyou.php?Status=success');//Where do you want to send them to after verification. 
    
    }  
  }
  $conn->close();
}


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="darkTheme.css">
    <script src="validation.js"></script>
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>(to be filled)</h2>
        <p>(to be filled)</p>
        
        <!--
        <div class="email">
          <label for="em">E-mail</label><br>
          <input type = "email" id="em" name="em" required placeholder="abcd@gmail.com"><br>
        </div>
        -->
            
        <div class="fname">
          <label for="fname">Full Name</label><br>
          <input type = "text" id="fname" name="fname" placeholder="Eg: Rithvik Senthil"><br>
        </div>

           
        <label for="phoneNumber">Phone Number</label><br>
        <input type = "text" id="phoneNumber" name="phoneNumber" placeholder="Eg: 7332809723"><br>
        
        <div style="text-align:center; padding:10px;">
          Gender:
          <div style="padding:5px; display:inline">
            <input type="radio" name="gender" id="male" value="M">
            <label for='male'>Male</label>
          </div>
          
          <div style="padding:5px; display:inline">
            <input type="radio" name="gender" id="female" value="F">
            <label for='female'>Female</label>
          </div>

          <div style="padding:5px; display:inline">
            <input type="radio" name="gender" id="other" value="O">
            <label for='other'>Other</label><br>
          </div>

        </div>

        <div style="text-align:center; padding:10px;">
          User Type:
          <div style="padding:10px; display:inline">
            <input type="radio" name="userType" id="worker" value="W">
            <label for='worker'>Worker</label>
          </div>
          
          <div style="padding:10px; display:inline">
            <input type="radio" name="userType" id="client" value="C">
            <label for='client'>Client</label><br>
          </div>
        </div>
            
        <label for="dOB">Date Of Birth</label><br>
        <input type="date" id="dOB" name="dOB"><br>

        <label for="pincode">Pincode</label><br>
        <input type="number" id="pincode" name="pincode" min="100000" max="999999" placeholder="Eg: 600025"><br>
    
        <label for="aadhaar">Aadhaar ID</label><br>
        <input type="number" id="aadhaar" name="aadhaar" min="1000000000000000" max="9999999999999999" placeholder="Eg: 2567776585865650"><br>

        <label for="pwd1">Password</label><br>
        <input type="password" id="pwd1" name="pwd1"  minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters"><br>

        <label for="pwd2">Confirm Password</label><br>
        <input type="password" id="pwd2" name="pwd2"  minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters"><br><br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
        <input type="text"  id="captcha" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
        
        <button type="submit" onclick="return validCaptcha()" name="submit" id="submit-button">Create Account</button>
        <p style="font-size :15px; " >Already a user ? <a href="login.php" style="text-decoration:none; font-size: 15px;">Login</a></p>
        

      </div> 
    </form>
  </body>
</html>