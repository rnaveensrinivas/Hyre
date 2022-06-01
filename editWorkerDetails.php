<?php

//only for worker side.
session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    $name=$_SESSION['name'];

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
    <title>hyre</title>
    <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
</head>


<body>
    <div class="logout">
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="margin-right:20px">Sign Out</button>
    </div>
    <div class="form">
        <h2>Edit Profile</h2>

        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5" style="text-align:center"><img
                            class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                            class="font-weight-bold">

                        </span><span class="text-black-50"></span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        

                        <form action="" method="POST" role="form" class="form-horizontal">


                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Working hours</label>
                                <input type="text" id="workingHours" name="workingHours" class="form-control" placeholder="Eg : 5am to 5pm" >
                                </div>

                                <div class="col-md-12"><label class="labels">Experience(in years)</label>
                                    <input type="number" id="experience" name="experience" min="0" max="100" class="form-control" placeholder="Eg : 4" >
                                </div>
                                <div class="col-md-12">
                                    <label for="jobType">Choose job</label>
                                    <select name="jobType" id="jobType" name="jobType">
                                        <option value="carpenter">Carpenter</option>
                                        <option value="cook">Cook</option>
                                        <option value="maid">Maid</option>
                                        <option value="painter">Painter</option>
                                    </select>
                                </div>

                                <div class="col-md-12"><label for="paymentMode" class="labels" name="paymentMode">Payment Mode </label>
                                <input type="text" id="paymentMode" class="form-control" placeholder="Eg : Cash, GPay" name="paymentMode"></div>
                                </div>
                                <br>
                                <div class="mt-5 text-center" style="text-align:center">
                                <button class="btn btn-primary profile-button" type="submit" name="submit">Save</button>
                                </div>
                                <div class="mt-5 text-center" style="text-align:center;  margin-top: 15px" >
                                <button class="btn btn-primary profile-button" type="submit" onclick="location.href='mainlobby.php'">Cancel</button>
                                </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    </div>
</body>

</html>