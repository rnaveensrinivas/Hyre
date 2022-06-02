<?php

//only for worker side.
session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    $workerID = $_SESSION['ID'] ;
    $getFeildsQuery = "SELECT * FROM account WHERE ID = '$workerID' " ;
    $resultSet = $conn->query($getFeildsQuery) ; 
    
    if( $resultSet->num_rows ){ 
        $row = $resultSet->fetch_assoc() ; 
        $pincode = $row['pincode'] ;
    }


    if ( isset($_POST['submit'])){ 
        //Getting the form data.
    
        $pincode = $_POST['pincode'] ;

        $checkPincodeIfExistsQuery = "SELECT * from tamilnadupincodes where pincode = '$pincode'" ; 
        $pincodeResult = mysqli_query( $conn , $checkPincodeIfExistsQuery ) ;

        if( $pincodeResult->fetch_assoc()){

            $resultSet = $conn->query("UPDATE account set pincode='$pincode' where ID='$workerID'") ; 
            if( $resultSet ){
                header("location:workerProfile.php") ; 
            }
            else{
                echo "<script>alert('Unable to update')</script>" ;
            }
        }
        else{
            echo "<script>alert('This pincode is not present in Tamil Nadu')</script>" ;
        }
       
    }
    $conn->close();
}
else if( $_SESSION['userType'] == "C"){ 
    header("locatoin:mainlobby.php");
}
else{
    header("location:index.html") ; 
}


?>

<!DOCTYPE html>
<html>

    <head>
        <title>Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
        <script src="1Level/validation.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    </head>

    <body onload="newCaptcha()">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!--navbar-expand aligns all components horizontally displayed-->
        <a class="navbar-brand ms-4" href="index.html">Hyre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarToggleButton">
          
        <ul class="navbar-nav px-4  ms-auto"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="logout.php">Sign out</a></li>
        </ul>
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>
        <form  action="" method="POST" >
            <div class="form">

                <h2>Change Pincode</h2>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>
            

                <label for="currentPincode">Current Pincode</label><br>
                <input type="number" id="currentPincode" name="currentPincode" value="<?php echo $pincode?>" readonly >

                <label for="pincode">New Pincode</label><br>
                <input type="number" id="pincode" name="pincode" min=600000 max=700000 placeholder="Eg : 600025"  >
                
                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="margin-top:25px; border-radius:5px">New Captcha</button>
                <input type="text"  id="captcha" oncopy="return false" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" onpaste="return false" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <button type="submit" onclick="return checkCaptcha()" name="submit" id="submit-button" style="border-radius:5px">Save</button>
                <button type="button" onclick="location.href='workerProfile.php'" style="border-radius:5px; margin-top :15px;" id="submit-button">Cancel</button>

            </div> 
        </form>
    </body>
</html>