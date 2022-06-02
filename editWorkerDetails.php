<?php

//only for worker side.
session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    $name=$_SESSION['name'];
    $workerID = $_SESSION['ID'] ;
    $getFeildsQuery = "SELECT * FROM worker WHERE workerID = '$workerID' " ;
    $resultSet = $conn->query($getFeildsQuery) ; 
    
    if( $resultSet->num_rows ){ 
        $row = $resultSet->fetch_assoc() ; 
        $workingHours = $row['workingHours'] ;
        $experience = $row['experience'] ;
        $jobType = $row['jobType'] ;
        $paymentMode = $row['paymentMode'] ;
    }


    if ( isset($_POST['submit'])){ 
        //Getting the form data.
    
        $workingHours = $_POST["workingHours"] ;
        $experience = $_POST["experience"] ;
        $jobType = $_POST["jobType"];
        $paymentMode = $_POST["paymentMode"];
        $ID = $_SESSION['ID'];

    
        //query the database. 
        $resultSet = $conn->query("UPDATE worker set  workingHours='$workingHours', experience='$experience', jobType='$jobType', paymentMode='$paymentMode' where workerID='$ID'") ; 
        if( $resultSet ){
            header("location:workerProfile.php") ; 
        }
        else{
            echo "<script>alert('Unable to update')</script>" ;
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

                <h2>Edit Profile</h2>
                <p>Change the necessary fields</p>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>

                <p>Change Pincode : <a href="changePincode.php" style="text-decoration:none; ">Here</a></p>

                <label for="workingHours">Working Hours</label><br>
                <input type="text" id="workingHours" name="workingHours" placeholder="Eg : 5am to 5pm" value="<?php echo $workingHours?>" required >

                <label for="experience">Experience(in years)</label><br>
                <input type="number" id="experience" name="experience" value="<?php echo $experience?>"min=0 max=60 placeholder="Eg : 4"  required >

                <label for="jobType" style="margin-top:20px">Job Category</label><br>
                <select name="jobType" id="jobType" style="width:100%; height:40px" value="<?php echo $jobType?>">
                <option value="carpenter">Carpenter</option>
                <option value="cook">Cook</option>
                <option value="maid">Maid</option>
                <option value="painter">Painter</option>
                </select><br>

                <label for="paymentMode">Payment Mode</label><br>
                <input type="text" id="paymentMode" name="paymentMode" placeholder="Eg : Cash or GPay" value="<?php echo $paymentMode?>" required >

                
                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="margin-top:25px; border-radius:5px">New Captcha</button>
                <input type="text"  id="captcha" oncopy="return false" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" onpaste="return false" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <button type="submit" onclick="return checkCaptcha()" name="submit" id="submit-button" style="border-radius:5px">Save</button>
                <button type="button" onclick="location.href='workerProfile.php'" style="border-radius:5px ; margin-top:  15px;" id="submit-button">Cancel</button>

            </div> 
        </form>
    </body>
</html>