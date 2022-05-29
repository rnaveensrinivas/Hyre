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

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 

    //To get the student table name. 
    $workerID = $_SESSION['ID'] ; 

    //For displaying all the teams they have enrolled in. 
    $selectAllRequests = "SELECT * FROM job where workerID='$workerID' and bookingStatus = 0" ; 
    if ( $result = mysqli_query( $conn, $selectAllRequests ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printClientID = $row['clientID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 

            echo "<h3>Client ID : $printClientID<br>Description : $printDescription<br>"; 
            echo "<form action='' method='POST'>";
            echo "<input type='submit' value='Accept' name='accept' id='submit-button'>" ; 
            echo "<input type='submit' value='Reject' name='reject' id='submit-button'>" ;
            echo "</form>" ;
            if( isset($_POST['accept'])){
                $_POST = array() ;
                $acceptRequestQuery = "update job set bookingStatus = 1, jobStatus = 1 where jobID ='$jobID'" ;
                if( $result = mysqli_query( $conn, $acceptRequestQuery ) ){
                    echo "<script>alert('Request for $printClientID accepted.')</script>" ;
                    echo "<script>location.reload()</script>" ;
                }
            }
            else if( isset($_POST['reject'])){
                $_POST = array() ;
                $rejectRequestQuery = "update job set bookingStatus = 2, jobStatus = 2 where jobID ='$jobID'" ;
                if( $result = mysqli_query( $conn, $rejectRequestQuery ) ){
                    echo "<script>alert('Request for $printClientID canceled.')</script>" ;
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
    $selectAllRequests = "SELECT * FROM job where clientID='$clientID' and bookingStatus = 0" ; 
    if ( $result = mysqli_query( $conn, $selectAllRequests ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printWorkerID = $row['workerID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 

            echo "<h3>Worker ID : $printWorkerID<br>Description : $printDescription<br>"; 
            echo "<form action='' method='POST'>";
            echo "<input type='submit' value='Cancel Request' name='cancelRequest' id='submit-button'>" ; 
            //echo "<input type='submit' value='Reject' name='reject' id='submit-button'>" ;
            echo "</form>" ;
            if( isset($_POST['cancelRequest'])){
                unset($_POST['cancelRequest']) ;
                $withdrawRequestQuery = "update job set bookingStatus = 3, jobStatus = 2 where jobID ='$jobID'" ;
                if( $result = mysqli_query( $conn, $withdrawRequestQuery ) ){
                    echo "<script>alert('Request for $printWorkerID has been withdrawn.')</script>" ;
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