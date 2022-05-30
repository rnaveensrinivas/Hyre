<!DOCTYPE html>
<html>
    <head>
        <title>Job Requests</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    </head>


    <body>
        <div class="logout">
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
        <div class="form">
            <h2>Request Queue</h2>

<?php

session_start() ; 
include 'config.php' ; 

if( $_SESSION['userType'] == "W"){ 

    $workerID = $_SESSION['ID'] ; 

    $selectAllRequests = "SELECT * FROM job where workerID='$workerID' and bookingStatus = 0" ; 
    if ( $result = mysqli_query( $conn, $selectAllRequests ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $clientID = $row['clientID'] ;
            $description = $row['description'] ;  
            $jobID = $row['jobID'] ; 
            $bookingStatus = $row['bookingStatus'] ;

            
            echo "<h3>Client ID : $clientID<br>Description : $description<br>"; 
            echo "<a href='viewRequest.php?jobID=$jobID&workerID=$workerID&clientID=$clientID&bookingStatus=$bookingStatus' id='submit-button'><button>View Request</button></a></h3>" ;
        }
    }
    
    $conn->close();
}   
else if( $_SESSION['userType'] == "C"){ 

    $clientID = $_SESSION['ID'] ; 

    $selectAllRequests = "SELECT * FROM job where clientID='$clientID' and bookingStatus = 0" ; 
    if ( $result = mysqli_query( $conn, $selectAllRequests ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $workerID = $row['workerID'] ;
            $description = $row['description'] ;  
            $jobID = $row['jobID'] ; 
            $bookingStatus = $row['bookingStatus'] ;


            echo "<h3>Worker ID : $workerID<br>Description : $description<br>"; 
            echo "<a href='viewRequest.php?jobID=$jobID&workerID=$workerID&clientID=$clientID&bookingStatus=$bookingStatus' id='submit-button'><button>View Request</button></a></h3>" ;
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