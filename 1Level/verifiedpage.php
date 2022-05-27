<?php
include('../config.php') ; 
if(isset($_GET['Vkey'])){ //To prevent Invalid Entry.
    //Process Verification. 

    $Vkey = $_GET['Vkey'] ; 

    $resultSet = $conn->query("SELECT Verified,Vkey FROM users WHERE Verified = 0 AND Vkey = '$Vkey' LIMIT 1"); 
    //LIMIT 1 => returns only one row if true.
    
    if( $resultSet->num_rows){ //If it is not verfied.
        //Validate The email. 
        $update = $conn->query("UPDATE users SET Verified = 1 where Vkey = '$Vkey' LIMIT 1 ") ;

        if($update){ 
            $resultSet = $conn->query("SELECT * FROM users WHERE Vkey = '$Vkey' LIMIT 1"); 
            $row = mysqli_fetch_assoc($resultSet) ; 
            $tablename = $row["CollegeID"] ; 
            $Category = $row["Category"] ; 

            if( $Category == "Student"){ 
                //Creating a dedicated table for the the student only.

                $tablename = "S" . $tablename ; 
                $run1 = mysqli_query($conn,"CREATE TABLE $tablename(TeamName varchar(45) PRIMARY KEY , Keycode varchar(10))");    
                
                //if(!$run1){
                //    echo mysqli_error($conn);
                //} 

            }
            $error .=  "Your account has been verified, you may now login." ;          
        }
        else{ 
            //echo $conn->error ; 
            $error = "Couldn't verify account. ";
        }
    }else { 
        $error .= "This account invalid or already verified. " ; 
    }

}else{ 
    //Invalid access detected.
?>
<html>
    <head>
        <title>Invalid </title>
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
        <title>Verify</title>
        <link rel="stylesheet" type="text/css" href="style2.css">
    </head>


    <body>
        <div class="form">
            <h2>Verification Status</h2>
            <p><?php echo $error ?></p>
        
            <button type="button" onclick="location.href='login.php'" id="submit-button">Login</button>
        </div> 
    </body>
</html>
