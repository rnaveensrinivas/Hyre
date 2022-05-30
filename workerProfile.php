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
            <li class="nav-item"><a class="nav-link" href="">Report</a></li>
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
                <h2>(to be filled)</h2>
                <h3>Worker Profile below</h3>
                <?php
                echo "<h3>Name : $printName "; 
                echo "<p>Average Rating : $printAverageRating<br>Experience : $printExperience</p>" ;
                if( $_SESSION['userType'] == "C" ){
                    echo "<a href='book.php?workerID=$workerID' id='submit-button'><button>Book Request</button></a></h3>" ;
                }

                ?>
            </div> 
            <div class="form">
                <h1>Comments</h1>
                <?php
                $selectAllComments = "SELECT * FROM comment where workerID='$workerID' " ; 
                if ( $result = mysqli_query( $conn, $selectAllComments) ) { 
                    while ( $row = mysqli_fetch_assoc($result) ) { 
            
                        $printClientID = $row['clientID'] ;
                        $printDescription = $row['description'] ;  
                        $jobID = $row['jobID'] ; 
            
                        echo "<h3>Client ID : $printClientID<br>Description : $printDescription<br>"; 
                        
                        //echo "<a href='teams.php?TeamName=$teams' id='submit-button'><button> Join </button></a></h3>" ;
                        //Joining a specific team page. And we are passing the team name using GET to that teams page.
                    }
                }

                ?>
            </div> 
    </body>
 </html> 

 <?php

        

        /*
        $TeacherID = $_SESSION['CollegeID'] ; 
        $TeamName = $_POST['TeamName'] ;
        $TeamName .= "_" ; 
        $TeamName .= $TeacherID ; //So that the team names for a teacher remains unique.

        //Checking if the class exists or not. 
        $query = "SELECT * FROM teams WHERE TeamName = '$TeamName' " ; 
        $result = $conn->query($query) ; 

        if( $result->num_rows ){
            //Team already exists.
            $error .= "This team Name already exists.Try again." ; 
        }
        else{
            $TeacherName = $_SESSION['FullName']  ;

            $Keycode = md5(time().$TeamName) ; //Creating an encryption Keycode.
            $Keycode = substr($Keycode,0,10) ; //Taking only the first 10 char of encryption created. 

            $query = "INSERT INTO teams(TeamName, TeacherName , TeacherID , Keycode ) VALUES('$TeamName', '$TeacherName' , '$TeacherID' , '$Keycode')" ; 
            $result = $conn->query($query) ; 

            if( $result ){
                echo"<script>alert('Team channel created succesfully.Redirecting to main lobby.') </script>" ; 
                echo"<script>document.location='mainlobby.php'</script>" ;
            }
            else{ 
                //echo mysqli_error($conn);
                echo"<script>alert('Unable to create team channel.Redirecting to main lobby.') </script>" ; 
                echo"<script>document.location='mainlobby.php'</script>" ; 
            }
        }
        */
    
        $conn->close();
    }
    else{ 
        header("location:index.html") ; 
    }
    ?>