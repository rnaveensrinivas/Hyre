<?php
session_start() ; 
include 'config.php' ; 

if( $_SESSION['userType'] ){
    $workerID = "" ;
    if( isset($_GET['workerID']) ){
        $workerID = $_GET['workerID'] ; 
    }
    else if( $_SESSION['userType'] == "W"){
        $workerID = $_SESSION['ID'] ;
    }
    else{
        //bring in java script here with alernt and then redirect.
        header("location:searchWorker.php") ;
    }

    
    $selectWorkers = "SELECT * FROM worker,account where worker.workerID=account.ID and workerID = '$workerID' ";
    $result = mysqli_query( $conn, $selectWorkers ) ;
    $row = mysqli_fetch_assoc($result) ;

    //for now displaying just the name and some necessary details. 

    $printName = $row['name'] ;
    $printAverageRating = $row['averageRating'] ;
    $printExperience = $row['experience'] ;
    $workerID = $row['workerID'] ; 
    
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Search Workers</title>
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
            <li class="nav-item"><a class="nav-link" href="">Sign out</a></li>
        </ul>
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>
        <div class="logout">
            <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
            <div class="form">
                <h2 style='text-align:center'>Worker Profile</h2>
                <?php
                echo "<p style='text-align:center'>Name : $printName<br>"; 
                echo "Average Rating : $printAverageRating<br>Experience : $printExperience</p>" ;
                if( $_SESSION['userType'] == "C" ){
                    echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px'><a href='book.php?workerID=$workerID' id='submit-button'><button>Book Request</button></a></h3></div>" ;
                }

                ?>
            </div> 
            <div class="form">
                <h3 style='text-align:center'>Comments on Worker</h3>
                <?php
                $selectAllComments = "SELECT * FROM comment where workerID='$workerID' " ; 
                if ( $result = mysqli_query( $conn, $selectAllComments) ) { 
                    while ( $row = mysqli_fetch_assoc($result) ) { 
            
                        $printClientID = $row['clientID'] ;
                        $printDescription = $row['description'] ;  
                        $jobID = $row['jobID'] ; 
            
                        echo "<div style='text-align:center'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px'>Client ID: $printClientID<br>Description: $printDescription<br></div>"; 
                        
                    }
                }
                ?>
            </div> 
    </body>
 </html>

 <?php
    
        $conn->close();
    }
    else{ 
        header("location:index.html") ; 
    }
?>