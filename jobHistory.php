<!DOCTYPE html>
<html>
    <head>
        <title>Job History</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
      
    </head>


    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--navbar-expand aligns all components horizontally displayed-->
            <a class="navbar-brand ms-4" href="">Hyre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            <div class="collapse navbar-collapse" id="#navbarToggleButton">
              <ul class="navbar-nav px-4 ms-auto"> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
            </ul>
            <ul class="navbar-nav px-4"> <!--from documentation-->
              <li class="nav-item"><a class="nav-link" href="">Contact</a></li>
          </ul>
          <ul class="navbar-nav px-4"> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="">Signout</a></li>
            </ul>

            </div>
        </nav>
        <div class="logout">
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
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
    $selectAllJobs = "SELECT * FROM job where workerID='$workerID' and jobStatus in( 2,3,4,5) " ; 
    if ( $result = mysqli_query( $conn, $selectAllJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printClientID = $row['clientID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 

            echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px' >Client ID : $printClientID<br>Description : $printDescription<br></div>"; 
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
    $selectAllJobs = "SELECT * FROM job where clientID='$clientID' and jobStatus in( 2,3,4,5) " ;
    if ( $result = mysqli_query( $conn, $selectAllJobs ) ) { 
        while ( $row = mysqli_fetch_assoc($result) ) { 

            $printWorkerID = $row['workerID'] ;
            $printDescription = $row['description'] ;  
            $jobID = $row['jobID'] ; 

            echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px' >Worker ID: $printWorkerID<br>Description: $printDescription<br></div>"; 
            echo "<a href='comment.php?workerID=$printWorkerID&jobID=$jobID' id='submit-button'><div style='text-align:center'><button style='border-radius:5px'>Comment</button></div></a></h3>" ;
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