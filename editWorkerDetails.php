<?php

//only for worker side.
session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    echo "Welcome worker." ;
    $name=$_SESSION['name'];

    if ( isset($_POST['submit'])){ 
        //Getting the form data.
    
        $workingHours=$_POST["workhrs"] ;
        $experience = $_POST["exp"] ;
        $job=$_POST["job"];
        $paymentDescription=$_POST["pymtDscpn"];
        $ID=$_SESSION['ID'];

    
        //query the database. 
        $resultSet = $conn->query("UPDATE worker set  workingHours='$workingHours', experience='$experience', job='$job', paymentDescription='$paymentDescription' where workerID='$ID'") ; 
        
       
    }
    /*
    //To get the student table name. 
    $tablename = $_SESSION['CollegeID'] ; 
    $tablename = "S" . $tablename ; 
    $_SESSION['studenttablename'] = $tablename ; 

    //For displaying all the teams they have enrolled in. 
    $selectAllTeamNames = "SELECT * FROM $tablename " ; 
    if ( $result = mysqli_query( $conn, $selectAllTeamNames ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 
            $teams = $row['TeamName'] ; 
            $PrintTeamName = substr($teams,0,-11) ;
            echo "<h3>Team : $PrintTeamName "; 
            echo "<a href='teams.php?TeamName=$teams' id='submit-button'><button> Join </button></a></h3>" ;
            //Joining a specific team page. And we are passing the team name using GET to that teams page.
        }
    }
    else{ 
        //echo "<script>alert('You have to join a new team.')</script>" ; 
    }
    */
    //Joining team below. 
?>




    <!-- <button onclick="location.href='jointeam.php'" id="submit-button">Join Team</button> -->

<?php

}else{ 
//Invalid access detected.
$conn->close();
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
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button"
            style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
    </div>
    <div class="form">
        <h2>Welcome to home Page.</h2>

        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img
                            class="rounded-circle mt-5" width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                            class="font-weight-bold">

                        </span><span class="text-black-50"></span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Edit Profile</h4>
                        </div>

                        <form action="mainlobby.php" method="POST" role="form" class="form-horizontal">


                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Working hours</label><input type="text"
                                        id="workhrs" class="form-control" placeholder="enter working hours" value="">
                                </div>
                                <div class="col-md-12"><label class="labels">Experience</label><input type="text"
                                        id="exp" class="form-control" placeholder="enter experience" value=""></div>
                                <div class="col-md-12">
                                    <label for="job">Choose job:</label>
                                    <select name="job" id="job">
                                        <option value="Carpenter">Carpenter</option>
                                        <option value="Cook">Cook</option>
                                        <option value="Maid">Maid</option>
                                        <option value="Painter">Painter</option>
                                    </select>
                                </div>

                                <div class="col-md-12"><label class="labels">Payment Description</label><input
                                        type="text" id="pymtDscpn" class="form-control"
                                        placeholder="enter payment description" value=""></div>
                            </div>
                            <br>
                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button"
                                    type="submit">Edit Profile</button></div>
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