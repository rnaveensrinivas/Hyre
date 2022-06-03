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

    $workerID = $row['workerID'] ; 
    $name = $row['workerName'] ;
    $jobType = $row['jobType'] ; 
    $workingHours = $row['workingHours'] ; 
    $phoneNumber = $row['phoneNumber'] ; 
    $gender = $row['gender'] ; 
    $averageRating = $row['averageRating'] ;
    $ratingCount = $row['ratingCount'] ;
    $paymentMode = $row['paymentMode'] ; 
    $experience = $row['experience'] ;
    $pincode = $row['pincode'] ;
    
    
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Search Workers</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
      
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
</head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!--navbar-expand aligns all components horizontally displayed-->
        <a class="navbar-brand ms-4" href="index.html">Hyre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarToggleButton">
        <ul class="navbar-nav px-4 ms-auto"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href='mainlobby.php'>Lobby</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href='logout.php'>Sign out</a></li>
        </ul>
        </div>
       
    </nav>
    
            <div class="form">
                <h2 style='text-align:center'>Worker Profile</h2>
                <?php
                echo "<p>Name : $name<br> workerID : $workerID<br>"; 
                echo "Job Type : $jobType<br> Phone Number : $phoneNumber<br>Gender : $gender<br>Working Hours : $workingHours<br>" ;
                echo "Payment Mode : $paymentMode<br>Average Rating : $averageRating ($ratingCount)<br>Experience : $experience<br>Pincode : $pincode<br>" ;

                if( $_SESSION['userType'] == "C" ){
                    echo "<div style='text-align:center;'><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px'><a href='book.php?workerID=$workerID' id='submit-button'><button style='border-radius:7px'>Book Request</button></a></h3></div>" ;
                }
                else{
                    ?>
                    <div><button type="button" onclick="location.href='editWorkerDetails.php'" name="editWorkerDetails" id="submit-button" style="margin-top:15px;  border-radius:5px">Edit</button></div>
                    <?php
                }

                ?>
            </div> 
            <div class="form">
                <h3 style='text-align:center'>Comments</h3>
                <?php
                $selectAllComments = "SELECT * FROM comment where workerID='$workerID' " ; 
                if ( $result = mysqli_query( $conn, $selectAllComments) ) { 
                    while ( $row = mysqli_fetch_assoc($result) ) { 
            
                        $printClientID = $row['clientID'] ;
                        $clientName = $row['clientName'] ;
                        $printDescription = $row['description'] ;  
                        $jobID = $row['jobID']; 
            
                        echo "<div><h3 style='font-size:1.25rem;font-weight:300; margin-top:20px; margin-bottom:20px'>Client Name: $clientName<br>Client ID: $printClientID<br>Description: $printDescription<br></div>"; 
                        
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