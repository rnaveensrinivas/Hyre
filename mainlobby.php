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
        <a class="navbar-brand ms-4" href="index.html">Hyre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="#navbarToggleButton">
          
        
        <ul class="navbar-nav px-4  ms-auto"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="jobRequests.php">Job Requests</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="upcomingJobs.php">Upcoming Jobs</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="jobHistory.php">Job History</a></li>
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
        

        <div class="form" style="margin-top:100px">
            <h2>Hi there.</h2>

<?php

session_start() ; 
include 'config.php' ; 

// Displaying student main lobby
if( $_SESSION['userType'] == "W"){ 
    
    $name = $_SESSION['name'];
    $ID = $_SESSION['ID'] ; 
    echo "<p>Welcome, $name.<br>User ID : $ID</p>" ;
?>
        <div>
        <button type="button" onclick="location.href='workerProfile.php'" name="workerProfile" id="submit-button" style="margin-top:15px;  border-radius:5px" >My profile</button>
        </div>

<?php
    
}   
else if( $_SESSION['userType'] == "C"){ 
    
    $name = $_SESSION['name'];
    echo "<div style='text-align:center'>Welcome $name, this is Client's Portfolio.</div>" ;

?>
        <div>
        <button type="button" onclick="location.href='searchWorker.php'" name="searchWorker" id="submit-button" style="margin-top:15px; border-radius:5px">Search Worker</button>
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

