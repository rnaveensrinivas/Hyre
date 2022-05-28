<?php
session_start() ; 
include 'config.php' ; 

if( $_SESSION['userType'] ){
    $workerID = "" ;
    if( isset($_GET['workerID']) ){
        $workerID = $_GET['workerID'] ; 
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
    </head>

    <body>
        
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