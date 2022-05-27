<?php

include '../config.php';

if( isset($_POST['submit'])){ //Checking if the form is submitted. 

    $em= $conn->real_escape_string($_POST["em"]); //getting the mail and sanitiziing it.
  
    $checkMailIfExists = "SELECT * FROM users WHERE Email = '$em'" ; //Checking if email already exists. 
    $mailResult = mysqli_query($conn , $checkMailIfExists) ; 

    if( $mailResult->fetch_assoc()){
        $to = $em ; 
        $subject = "Reset Password." ; 
        // I am sending $vkey along with the page in mail.
        $message = "<p>Hi thanks for approaching Eduvate support to change account password please click <a href='http://localhost/Eduvate-app/1Level/password.php?em=$em'>Here</a></p>" ; 
        $headers = "From: appeduvate@gmail.com \r\n" ; //App i am send form. 
        $headers .= "MIME-Version: 1.0" . "\r\n" ; // \r - return carriage || \n - newline 
        $headers .= "Content-type:text/html;charset=UTF-8". "\r\n" ; 

        mail($to , $subject , $message, $headers) ; 

        header('location:thankyou.php?Status=Sent');
    } 
    else{    
        $error .= "The entered email is invalid." ; 
    }  
}

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <link rel="stylesheet" type="text/css" href="style2.css">
    </head>
    <body>
        <form method="POST" action="" autocomplete="off">
            <div class="form">
                <h2>Reset Password</h2>
                <p>Enter your registered email address to reset the password.</p>
                <p style="color:red; line-height: 120%; "> <?php echo $error ; ?></p>
                <div class="email">
                    <label for="em">E-mail</label><br>
                    <input type = "email" id="em" name="em" required placeholder="abcd@gmail.com"><br>
                </div>
                <button type="submit" name="submit" id="submit-button">Send Mail</button>
            </div> 
        </form>
    </body>
 </html> 