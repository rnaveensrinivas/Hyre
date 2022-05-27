<?php
include 'config.php';

if( isset($_POST['signup'])){ //Checking if the form is submitted. 


    $phoneNumber = $_POST['phoneNumber'] ;
    $aadhaar = $_POST['aadhaar'] ;
    $password = $_POST['password'] ;
    $repeatPassword = $_POST['repeatPassword'] ;

    $checkPhoneNumberIfExists = "SELECT * FROM account WHERE phoneNumber = '$phoneNumber'" ; //Checking if email already exists. 
    $checkAadhaarIfExists = "SELECT * FROM account WHERE aadhaar = '$aadhaar'" ; //Checking if College ID already exists. 
    $numberResult = mysqli_query($conn , $checkPhoneNumberIfExists) ; 
    $aadhaarResult =  mysqli_query($conn , $checkAadhaarIfExists) ; 


    if( $numberResult->fetch_assoc() ){
        echo "<script>alert('This PhoneNumber already exists. Go to login page.')</script>" ; 
    }
    else if( $aadhaarResult->fetch_assoc()){
        echo "<script>alert('This Aadhaar already exists. Go to login page.')</script>" ; 
    }
    else if( $password != $repeatPassword ){ 
        echo "<script>alert('Passwords do not match.')</script>";
    }
    else{    //Server Side validation is done. 

    //Getting rest of the details here. 
        $name = $_POST['name'] ;
        $gender = $_POST['gender'] ;
        $dOB = $_POST['dOB'] ;
        $pincode = $_POST['pincode'] ;
        $userType = $_POST['userType'] ;

        //sanitize form data. - removes all illegal form data.

        $name = $conn->real_escape_string($name) ;
        $gender = $conn->real_escape_string($gender) ;
        $aadhaar = $conn->real_escape_string($aadhaar) ;
        $dOB = $conn->real_escape_string($dOB) ;
        $pincode = $conn->real_escape_string($pincode) ;
        $phoneNumber = $conn->real_escape_string($phoneNumber) ;
        $password = $conn->real_escape_string($password) ;
        $repeatPassword = $conn->real_escape_string($repeatPassword) ;
        $userType = $conn->real_escape_string($userType); 
        
        //encrypting the password. 
        $password = md5($password) ; //md5() is an encrypting function. 

        //generate unique id.
        $ID = md5($aadhaar) ; // based on timestamp.  
        
        $insert = $conn->query("INSERT INTO account(name,phoneNumber,gender,dOB,pincode,aadhaar,password,userType,ID,accountStatus,reportCount) values('$name','$phoneNumber','$gender','$dOB','$pincode','$aadhaar','$password','$userType','$ID',0,0)") ;

        /*
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
        */  
    }
    $conn->close();
}


?>


<!DOCTYPE html>

<html>

<head>
    <style>
        table,
        td,
        th {
            text-align: center;
            border: 3px solid black;
            border-collapse: collapse;
            padding: 10px;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <title>signup</title>
</head>

<body>
    <form method="POST" action="" autocomplete="off">
        <table class="center">
            <tr>
                <td><label for="name">Name</label></td>
                <td><input type="text" name="name" id="name" required placeholder="Rithvik Senthil"></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <input type="radio" id="male" name="gender" value="M" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="F">
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="O">
                    <label for="other">Other</label>
                </td>
            </tr>
            <tr>
                <td>User Type</td>
                <td>
                    <input type="radio" id="client" name="userType" value="C" required>
                    <label for="client">Client</label>
                    <input type="radio" id="worker" name="userType" value="W" >
                    <label for="worker">Worker</label>
                </td>
            </tr>
            <tr>
                <td><label for="aadhaar">Aadhaar</label></td>
                <td><input type="number" name="aadhaar" min="1000000000000000" max="9999999999999999" id="aadhaar" required></td>
            </tr>
            <tr>
                <td><label for="dOB">Date Of Birth</label></td>
                <td><input type="date" name="dOB" id="dOB" required></td>
            </tr>
            <tr>
                <td><label for="pincode">Pincode</label></td>
                <td><input type="number" name="pincode" id="pincode" min="100000" max="999999" required></td>
            </tr>
            <tr>
                <td><label for="phoneNumber">Phone Number</label></td>
                <td><input type="number" name="phoneNumber" id="phoneNumber" min="1000000000" max="9999999999" required></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input type="password" name="password" id="password" minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters"><br> </td>
            </tr>
            <tr>
                <td><label for="repeatPassword">Repeat Password</label></td>
                <td><input type="password" name="repeatPassword" id="repeatPassword" minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters"><br> </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" id="signup" value="Signup" name="signup"></td>
            </tr>
        </table>
    </form>
</body>

</html>