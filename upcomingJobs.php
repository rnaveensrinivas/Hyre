<!DOCTYPE html>
<html>
    <head>
        <title>Upcoming Jobs</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    </head>


    <body>
        <div class="logout">
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
        <div class="form">
            <h2>Upcoming Jobs</h2>

<?php

session_start() ; 
include 'config.php' ; 

if( $_SESSION['userType'] == "W"){ 

    $workerID = $_SESSION['ID'] ; 

    $selectAllUpcomingJobs = "SELECT * FROM job where workerID='$workerID' and jobStatus = 1" ; 
    if ( $result = mysqli_query( $conn, $selectAllUpcomingJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $clientID = $row['clientID'] ;
            $description = $row['description'] ;  
            $jobID = $row['jobID'] ;
            $jobStatus = $row['jobStatus'] ;  

            
            echo "<h3>Client ID : $clientID<br>Description : $description<br>"; 
            echo "<a href='viewUpcomingJob.php?jobID=$jobID&workerID=$workerID&clientID=$clientID&jobStatus=$jobStatus' id='submit-button'><button>View Job</button></a></h3>" ;
        }
    }
    
    $conn->close();
}   
else if( $_SESSION['userType'] == "C"){ 

    $clientID = $_SESSION['ID'] ; 

    $selectAllUpcomingJobs = "SELECT * FROM job where clientID='$clientID' and jobStatus = 1" ; 
    if ( $result = mysqli_query( $conn, $selectAllUpcomingJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $workerID = $row['workerID'] ;
            $description = $row['description'] ;  
            $jobID = $row['jobID'] ; 
            $jobStatus = $row['jobStatus'] ;  


            echo "<h3>Worker ID : $workerID<br>Description : $description<br>"; 
            echo "<a href='viewUpcomingJob.php?jobID=$jobID&workerID=$workerID&clientID=$clientID&jobStatus=$jobStatus' id='submit-button'><button>View Job</button></a></h3>" ;
        }
    }
$conn->close();
}else{ 
//Invalid access detected.
$conn->close();
header("location:index.html") ; 

}

?>

        </div> 
    </body>
</html>