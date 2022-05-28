<!DOCTYPE html>
<html>
    <head>
        <title>Hyre</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    </head>


    <body>

        <div class="logout">
        <button type="button" onclick="location.href='report.php'" name="report" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Report</button>
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>

        <div class="form">
            <h2>Hi there.</h2>

<?php

session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    
    $name = $_SESSION['name'];
    echo "Welcome $name, this is workers lab." ;
?>
        <div>
        <button type="button" onclick="location.href='editWorkerDetails.php'" name="editWorkerDetails" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Edit my info.</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobRequests.php'" name="jobRequests" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">My job Requests</button>
        </div>
        <div>
        <button type="button" onclick="location.href='upcomingJobs.php'" name="upcomingJobs" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Upcoming jobs</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobHistory.php'" name="jobHistory" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Job History</button>
        </div>

<?php
    /*
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

    //Joining team below. 
?>

    <button onclick="location.href='jointeam.php'" id="submit-button">Join Team</button>

<?php
    */
}   // Displaying teacher main lobby
else if( $_SESSION['userType'] == "C"){ 
    
    $name = $_SESSION['name'];
    echo "Welcome $name, this is client's Portfolio." ;

?>
        <div>
        <button type="button" onclick="location.href='searchWorker.php'" name="searchWorker" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Search Worker</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobRequests.php'" name="jobRequests" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sent Requests</button>
        </div>
        <div>
        <button type="button" onclick="location.href='upcomingJobs.php'" name="upcomingJobs" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Upcoming jobs</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobHistory.php'" name="jobHistory" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Job History</button>
        </div>
        

<?php



    /*
    $CollegeID  = $_SESSION['CollegeID'] ; 

    // Trying to display all the teams teacher has created.
    $selectAllTeam = "SELECT * FROM teams where TeacherID = '$CollegeID' " ; 
    if ( $result = mysqli_query( $conn, $selectAllTeam ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 
            $teams = $row['TeamName'] ; 
            $PrintTeamName = substr($teams,0,-11) ;
            echo "<h3>Team : $PrintTeamName "; 
            echo "<a href='teams.php?TeamName=$teams' id='submit-button'><button> Join </button></a></h3>" ;
            //Joining a specific team page. And we are passing the team name using GET to that teams page.
        }
    }
    //creating team below. 
?>

    <button onclick="location.href='createteam.php'" id='submit-button'>Create Team</a></button>

<?php
     */
}else{ 
//Invalid access detected.
$conn->close();
header("location:index.html") ; 

}

?>

        </div> 
    </body>
</html>

