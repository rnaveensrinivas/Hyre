<?php
include('../config.php') ; 

if( isset($_GET['em']) ){ // To prevenet invalid entry.
    if(isset($_POST['submit'])){
        $em = $_GET['em'] ; 

        $checkMailIfExists = "SELECT * FROM users WHERE Email = '$em' LIMIT 1"; 
        $mailResult = mysqli_query($conn , $checkMailIfExists) ; 

        if( $mailResult->fetch_assoc() ){ 
            //Valid email. 
            $pwd1 = $_POST['pwd1'] ; 
            $pwd2 = $_POST['pwd2'] ; 

            if( $pwd1 != $pwd2){ 
                echo "<script>alert('The Passwords do not match. Try again.')</script>" ; 
            }
            else{ 
                $pwd1= $conn->real_escape_string($pwd1);//sanitizing
                $pwd1 = md5($pwd1); //encrypting
  
                $updatePassword = "UPDATE users SET Password1 = '$pwd1' where Email = '$em' " ; 
                $result = mysqli_query($conn , $updatePassword) ; 

                if($result){ 
                    echo "<script>alert('The password has been changed succefully you may now login.'); document.location='login.php'</script>" ;
                }
                else{ 
                    echo "<script>alert('Something went wrong. Try again.')</script>" ; 
                    header('location:password.php') ; 
                }
            }
        }
        else { 
            echo "<script>alert('The account doesn't seem to exist.Redirecting to Reset Password Page.')</script>" ;
            header('location:resetpassword.php') ; 
        }
    }   
}
else{ 
    //Invalid access detected.
    ?>
<html>
    <head>
        <title>Invalid</title>
        <link rel="stylesheet" type="text/css" href="style2.css">
    </head>
    <body>
        <div class="form">
            <h2>Invalid Access Detected</h2>       
        </div> 
    </body>
</html>

<?php
    die("") ; 
}

$conn->close() ; 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Password</title>
        <link rel="stylesheet" type="text/css" href="style2.css">
        <script src="valid.js"></script>
    </head>
    
    <body>
        <form method="POST" action="" autocomplete="off" onsubmit="return checkPassword()">
            <div class="form">
                <h2>Password</h2>
                <p>Enter the new password.</p>
      
                <label for="pwd1">Password</label><br>
                <input type="password" id="pwd1" name="pwd1"  minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters"><br>

                <label for="pwd2">Confirm Password</label><br>
                <input type="password" id="pwd2" name="pwd2"  minlength="8" pattern="[0-9a-fA-F!@#$%^&*_-.\|/><,';:]" placeholder="Must have atleast 8 characters"><br><br>

                <button type="submit" name="submit" id="submit-button">Reset Password</button>
            </div> 
        </form>
    </body>

</html>