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

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 

    //To get the student table name. 
    $workerID = $_SESSION['ID'] ; 

    //For displaying all the teams they have enrolled in. 
    $selectAllUpcomingJobs = "SELECT * FROM job where workerID='$workerID' and bookingStatus = 1 and jobstatus = 1" ; 
    if ( $result = mysqli_query( $conn, $selectAllUpcomingJobs) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printClientID = $row['clientID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 

            echo "<h3>Client ID : $printClientID<br>Description : $printDescription<br>"; 
            echo "<form action='' method='POST'>";
            echo "<input type='submit' value='Cancel Job' name='cancelJob' id='submit-button'>" ; 
            echo "</form>" ;
            if( isset($_POST['cancelJob'])){
                unset($_POST['cancelJob']) ;
                $cancelBookingByWorkerQuery = "update job set jobStatus = 3 where jobID ='$jobID'" ;
                if( $result = mysqli_query( $conn, $cancelBookingByWorkerQuery ) ){
                    echo "<script>alert('Booked job for $printClientID Cancelled.')</script>" ;
                    echo "<script>location.reload()</script>" ;
                }
                
            }
            //echo "<a href='teams.php?TeamName=$teams' id='submit-button'><button> Join </button></a></h3>" ;
            //Joining a specific team page. And we are passing the team name using GET to that teams page.
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
    $selectAllUpcomingJobs = "SELECT * FROM job where clientID='$clientID' and jobstatus = 1" ; 
    if ( $result = mysqli_query( $conn, $selectAllUpcomingJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printWorkerID = $row['workerID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 

            echo "<h3>Worker ID : $printWorkerID<br>Description : $printDescription<br>"; 
            echo "<form action='' method='POST'>";
            echo "<input type='submit' value='Cancel Job' name='cancelJob' id='submit-button'>" ; 
            //echo "<input type='submit' value='Reject' name='reject' id='submit-button'>" ;
            echo "</form>" ;
            if( isset($_POST['cancelJob'])){
                unset($_POST['cancelJob']) ;
                $withdrawRequestQuery = "update job set, jobStatus = 4 where jobID ='$jobID'" ;
                if( $result = mysqli_query( $conn, $withdrawRequestQuery ) ){
                    echo "<script>alert('Booked Job for $printWorkerID cancelled.')</script>" ;
                    echo "<script>location.reload()</script>" ;
                }
            }
            //echo "<a href='teams.php?TeamName=$teams' id='submit-button'><button> Join </button></a></h3>" ;
            //Joining a specific team page. And we are passing the team name using GET to that teams page.
        }
    }
    else{ 
        //echo "<script>alert('You have to join a new team.')</script>" ; 
    }
?>

    <!--<button onclick="location.href='createteam.php'" id='submit-button'>Create Team</a></button>-->

<?php
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