<!DOCTYPE html>
<html>
    <head>
        <title>Job History</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    </head>


    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!--navbar-expand aligns all components horizontally displayed-->
        <a class="navbar-brand ms-4" href="index.html">Hyre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarToggleButton">
          
        <ul class="navbar-nav px-4  ms-auto"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="mainlobby.php">Lobby</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="jobRequests.php">Job Requests</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="upcomingJobs.php">Upcoming Jobs</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="report.php">Report User</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="logout.php">Sign out</a></li>
        </ul>
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>

        <div class="form">
            <h2>Job History</h2>

<?php

session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 

    //To get the student table name. 
    $workerID = $_SESSION['ID'] ; 

    //For displaying all the teams they have enrolled in. 
    $selectAllJobs = "SELECT * FROM job where workerID='$workerID' and jobStatus in( 2,3,4,5) order by date desc" ; 
    if ( $result = mysqli_query( $conn, $selectAllJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printClientID = $row['clientID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 
            $clientName = $row['clientName'] ; 
            $date = $row['date'] ; 


            echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px' >Date : $date<br>Client Name : $clientName<br>Client ID : $printClientID<br>Description : $printDescription<br></div>"; 
            echo "<a href='report.php?ID=$printClientID' id='submit-button'><div style='text-align:center'><button style='border-radius:5px'>Report</button></div></a></h3>" ;
        }
    }
    else{ 
        //echo "<script>alert('You have to join a new team.')</script>" ; 
    }
    $conn->close();
    //Joining team below. 
?>

    <!--<button onclick="location.href='jointeam.php'" id="submit-button">Join Team</button> -->

<?php

}   // Displaying teacher main lobby
else if( $_SESSION['userType'] == "C"){ 

    //To get the student table name. 
    $clientID = $_SESSION['ID'] ; 

    //For displaying all the teams they have enrolled in. 
    $selectAllJobs = "SELECT * FROM job where clientID='$clientID' and jobStatus in( 2,3,4,5) order by date desc " ;
    if ( $result = mysqli_query( $conn, $selectAllJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printWorkerID = $row['workerID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 
            $workerName = $row['workerName'] ;
            $date = $row['date'] ; 

            echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px' >Date : $date<br>Worker Name : $workerName<br>Worker ID: $printWorkerID<br>Description: $printDescription<br></div>"; 
            echo "<a href='comment.php?workerID=$printWorkerID&jobID=$jobID' id='submit-button'><div style='text-align:center'><button style='border-radius:5px'>Comment</button></div></a></h3>" ;
            echo "<a href='report.php?ID=$printWorkerID' id='submit-button'><div style='text-align:center'><button style='border-radius:5px'>Report</button></div></a></h3>" ;

        }
    }
    else{ 
    }
?>


<?php
$conn->close();
}else{ 
$conn->close();
header("location:index.html") ; 

}

?>

        </div> 
    </body>
</html>