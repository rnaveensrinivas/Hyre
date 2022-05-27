<?php
include '../config.php';

if( isset($_POST['submit'])){ //Checking if the form is submitted. 

  $em=$_POST["em"];
  $uid=$_POST["uid"];
  $pwd1=$_POST["pwd1"]; 
  $pwd2=$_POST["pwd2"];

  $checkMailIfExists = "SELECT * FROM users WHERE Email = '$em'" ; //Checking if email already exists. 
  $checkCollegeIDIfExists = "SELECT * FROM users WHERE CollegeID = '$uid'" ; //Checking if College ID already exists. 
  $mailResult = mysqli_query($conn , $checkMailIfExists) ; 
  $collegeIDResult =  mysqli_query($conn , $checkCollegeIDIfExists) ; 


  if( $mailResult->fetch_assoc()){
    echo "<script>alert('This Email already exists. Go to login page.')</script>" ; 
  }
  else if( $collegeIDResult->fetch_assoc()){
    echo "<script>alert('This College Id already exists. Go to login page.')</script>" ; 
  }
  else if( $pwd1 != $pwd2 ){ 
    echo "<script>alert('Passwords do not match.')</script>";
  }
  else{    //Server Side validation is done. 

    //Getting rest of the details here. 
    $fname=$_POST["fname"];
    $col=$_POST["col"];
    $categ=$_POST["categ"];

    //sanitize form data. - removes all illegal form data.
    $em= $conn->real_escape_string($em);
    $fname=$conn->real_escape_string($fname);
    $col=$conn->real_escape_string($col);
    $categ=$conn->real_escape_string($categ);
    $uid=$conn->real_escape_string($uid);
    $pwd1=$conn->real_escape_string($pwd1); 
      
    //encrypting the password. 
    $pwd1 = md5($pwd1) ; //md5() is an encrypting function. 

    //generate Vkey
    $Vkey = md5(time().$fname) ; // based on timestamp.  
      
    $insert = "INSERT INTO Users (Email,FullName,College,Category,CollegeID,Password1,Vkey) VALUES ('$em','$fname','$col','$categ','$uid','$pwd1','$Vkey')";

    if ($conn->query($insert)) { 
      //Sending Email Verification.
    
      $to = $em ; 
      $subject = "Account Verification." ; 
      // I am sending $vkey along with the page in mail.
      $message = "<p> Hi thanks for signing up with Eduvate to Verify your account please click <a href='http://localhost/Eduvate-app/1Level/verifiedpage.php?Vkey=$Vkey'>Here</a></p>" ; 
      $headers = "From: appeduvate@gmail.com \r\n" ; //App i am send form. 
      $headers .= "MIME-Version: 1.0" . "\r\n" ; // \r - return carriage || \n - newline 
      $headers .= "Content-type:text/html;charset=UTF-8". "\r\n" ; 

      mail($to , $subject , $message, $headers) ; 

      header('location:thankyou.php?Status=Sent');//Where do you want to send them to after verification. 
    }  
  }
  $conn->close();
}


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <script src="validation.js"></script>
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>A New Pedagogy Awaits!</h2>
        <p>One account to start your Eduvation journey.</p>
        
        <div class="email">
          <label for="em">E-mail</label><br>
          <input type = "email" id="em" name="em" required placeholder="abcd@gmail.com"><br>
        </div>
            
        <div class="fname">
          <label for="fname">Full Name</label><br>
          <input type = "text" id="fname" name="fname" placeholder="Eg: Rithvik Senthil"><br>
        </div>

           
        <label for="col">College</label><br>
        <input type = "text" id="col" name="col"placeholder="Eg: College Of Engineering, Guindy"><br>
        
        <div style="text-align:center; padding:10px;">
          Choose:
          <div style="padding:10px; display:inline">
            <input type="radio" name="categ" id="student" value="Student">
            <label for='student'>Student</label>
          </div>
          
          <div style="padding:10px; display:inline">
            <input type="radio" name="categ" id="teacher" value="Teacher">
            <label for='teacher'>Teacher</label><br>
          </div>
        </div>
            
    
        <label for="uid">College ID</label><br>
        <input type="number" id="uid" name="uid" min="1000000000" max="9999999999" placeholder="1234567890"><br>

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