<?php
session_start() ; 

include 'config.php'; 

if ( isset($_POST['login'])){ 
    //Getting the form data.
    $phoneNumber = $conn->real_escape_string($_POST["phoneNumber"]) ; // Sanitizing upon arrival. 
    $password = md5($conn->real_escape_string($_POST["password"])) ;

    //query the database. 
    $resultSet = $conn->query("SELECT * FROM account WHERE phoneNumber = '$phoneNumber' AND password = '$password' LIMIT 1") ; 
    
    if( $resultSet->num_rows ){ 
        //Process Login. 
        $row = $resultSet->fetch_assoc() ; 
        /*
        $name = $row['Verified'] ; 
        $em_database = $row['Email'] ; 
        $CollegeID = $row['CollegeID'] ; 
        $Password1 = $row['Password1'] ; 
        $createdDate = $row['CreatedDate'] ;
        $Category = $row['Category'] ; 
        $FullName = $row['FullName'] ;  
        */
        $accountStatus = $row['accountStatus'] ;
        $userType = $row['userType'] ;

        $_SESSION['userType'] = $userType ; 

        /*
        $_SESSION['CollegeID'] = $CollegeID ;
        $_SESSION['Password1'] = $Password1 ; 
        $_SESSION['FullName'] = $FullName ;   
        $_SESSION['Category'] = $Category ; 
        */
        if ( $accountStatus == 1 ){ // if it is a verifed account.
            header('location:mainlobby.php');
        }
        else if( $accountStatus == 1 ){ 
            $error .= "This account is blocked."; 
        }
        else{
            $error .= "This account needs to be verified." ;
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
    <title>Login</title>
</head>

<body>
    <form method="POST" action="">
        <table class="center">
            <tr >
                <td colspan="2"> <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p></td>
            </tr>
            <tr>
                <td><label for="phoneNumber">Phone Number</label></td>
                <td><input type="number" id="phoneNumber" min="1000000000" max="9999999999" name="phoneNumber"></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td><input type="password" id="password" minlength="8" name="password"></td>
            </tr>
            <tr>
                <td colspan="2"> <button type="submit" name="login" id="login">Login</button></td>
            </tr>
        </table>
    </form>
</body>

</html>