<!DOCTYPE html>
<html>
    <head>
        <title>Hyre</title>
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
        <ul class="navbar-nav "> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="">Login</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="">Signup</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="">Report</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="">Sign out</a></li>
        </ul>
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>
        <div class="logout">
        <button type="button" onclick="location.href='report.php'" name="report" id="submit-button" sty>Report</button>
        <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="margin-top:15px">Sign Out</button>
        </div>

        <div class="form" style="margin-top:100px">
            <h2>Hi there.</h2>

<?php

session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    
    $name = $_SESSION['name'];
    echo "<p>Welcome, $name.</p>" ;
?>
        <div>
        <button type="button" onclick="location.href='workerProfile.php'" name="workerProfile" id="submit-button" style="margin-top:15px" >My profile</button>
        </div>
        <div>
        <button type="button" onclick="location.href='editWorkerDetails.php'" name="editWorkerDetails" id="submit-button" style="margin-top:15px">Edit my info</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobRequests.php'" name="jobRequests" id="submit-button" style="margin-top:15px">Job requests</button>
        </div>
        <div>
        <button type="button" onclick="location.href='upcomingJobs.php'" name="upcomingJobs" id="submit-button" style="margin-top:15px">Upcoming jobs</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobHistory.php'" name="jobHistory" id="submit-button" style="margin-top:15px" >Job history</button>
        </div>

<?php
    
}   
else if( $_SESSION['userType'] == "C"){ 
    
    $name = $_SESSION['name'];
    echo "Welcome $name, this is client's Portfolio." ;

?>
        <div>
        <button type="button" onclick="location.href='searchWorker.php'" name="searchWorker" id="submit-button" style="margin-top:15px; border-radius:5px">Search Worker</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobRequests.php'" name="jobRequests" id="submit-button" style="margin-top:15px;border-radius:5px">Sent Requests</button>
        </div>
        <div>
        <button type="button" onclick="location.href='upcomingJobs.php'" name="upcomingJobs" id="submit-button" style="margin-top:15px;border-radius:5px">Upcoming jobs</button>
        </div>
        <div>
        <button type="button" onclick="location.href='jobHistory.php'" name="jobHistory" id="submit-button" style="margin-top:15px;border-radius:5px">Job History</button>
        </div>
        

<?php


}else{ 
    //Invalid access detected.
    $conn->close();
    header("location:index.html") ; 

}

?>

        </div> 
    </body>
</html>

