<!DOCTYPE html>
<html>
    <head>
        <title>Job Requests</title>
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

            
            echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px'>Client ID: $clientID<br>Description: $description<br></div>"; 
            echo "<a href='viewRequest.php?jobID=$jobID&workerID=$workerID&clientID=$clientID&bookingStatus=$bookingStatus' id='submit-button'><div style='text-align:center'><button style='border-radius:5px; width:50%'>View Request</button></div></a></h3>" ;
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


            echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px'>Worker ID: $workerID<br>Description: $description<br></div>"; 
            echo "<a href='viewRequest.php?jobID=$jobID&workerID=$workerID&clientID=$clientID&bookingStatus=$bookingStatus' id='submit-button'><div style='text-align:center'><button style='border-radius:5px; width:50%'>View Request</button></div></a></h3>" ;
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