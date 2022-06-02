<?php

session_start() ; 
include 'config.php' ; 

$workerID ="" ;
if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
    $query = "SELECT * FROM searchworker WHERE workerID = '$workerID' " ; 
    $result = $conn->query($query) ; 
    $row = mysqli_fetch_assoc($result) ; 
    $jobType = $row['jobType'] ; 
    $pincode = $row['pincode'] ; 
    $workerName = $row['name'] ; 
}



if( $_SESSION['userType'] == "C" ){
    if(isset($_POST['submit'])){ 

        $workerID = $_POST['workerID'] ;
        
        //we can another query here to check if the job matches with the worker.
        //have to implement this later.

        $query = "SELECT * FROM worker WHERE workerID = '$workerID' " ; 
        $result = $conn->query($query) ; 

        if( $result->num_rows ){ // ($resultSet->num_rows != 0)
            //If there exist a worker with that id, continue.

            $row = mysqli_fetch_assoc($result) ; 

            $workerID = $_POST['workerID'] ; 
            $jobType = $_POST['jobType'] ;
            $date = $_POST['date'] ; 
            $time = $_POST['time'] ; 
            $description = $_POST['description'] ;
            $pincode = $_POST['pincode'] ; 
            $landmark = $_POST['landmark'] ; 
            $clientID = $_SESSION['ID'] ;
            $clientName = $_SESSION['name'] ; 

            $query = "insert into job(clientID, clientName, workerID, workerName, landmark, pincode, time, date, workType, description,bookingStatus, jobStatus, clientRating, workerRating) values('$clientID', '$clientName', '$workerID', '$workerName', '$landmark' , '$pincode', '$time', '$date', '$workType', '$description', 0 , 0 , 0 , 0 )" ; 
            $result = $conn->query($query) ; 

            if( $result ){ 
                echo"<script>alert('Request made successfully. Redirecting to main lobby.') </script>" ; 
                echo"<script>document.location='mainlobby.php'</script>" ;

            }else{ 
                echo"<script>alert('Unable to make a request. Try again Late.Redirecting to main lobby.')</script>" ; 
                echo"<script>document.location='mainlobby.php'</script>" ;
            }  

        }
        else{ 
            $error = 'Invalid workerID. Try again.' ; 
        }   
        $conn->close();
    }   
}
else if( $_SESSION['userType'] == "W" ){
    header("location:mainlobby.php") ;
}
else{ 
    header("location:index.html") ; 
}

?>



<!DOCTYPE html>
<html>
  <head>
    <title>Request</title>
    <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    <script src="1Level/validation.js"></script>
  </head>


  <body onload="newCaptcha()">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <!--navbar-expand aligns all components horizontally displayed-->
            <a class="navbar-brand ms-4" href="index.html">Hyre</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            <div class="collapse navbar-collapse" id="navbarToggleButton">
              
            <ul class="navbar-nav px-4 ms-auto"> <!--from documentation-->
              <li class="nav-item"><a class="nav-link" href="mainlobby.php">Lobby</a></li>
            </ul>
    
            <ul class="navbar-nav px-4"> <!--from documentation-->
                <li class="nav-item"><a class="nav-link" href="logout.php">Sign Out</a></li>
            </ul>
            </div>
        </nav>
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>Book a Request</h2>
        

        <label for="name">Worker Name</label><br>
        <input type = "text" id="name" name="name" value='<?php echo $workerName ?>' required readonly> <br>

        <div class="fname">
          <label for="workerID">Worker ID</label><br>
          <input type = "text" id="workerID" name="workerID" placeholder="Eg: fhsd8sfdfkj242Gsf23423" value='<?php echo $workerID ?>' required readonly> <br>
        </div>

        <label for="jobType">Job Type</label><br>
        <input type = "text" id="jobType" name="jobType" value='<?php echo $jobType ?>' required readonly> <br>

        <label for="pincode">Pincode</label><br>
        <input type="number" id="pincode" name="pincode" min="100000" max="999999" placeholder="Eg: 600025" value='<?php echo $pincode ?>' required readonly><br>

        <label for="date">Date of Job</label><br>
        <input type="date" id="date" name="date" required><br>

        <label for="time">Time of Job</label><br>
        <input type = "text" id="time" name="time" placeholder="Eg: 3pm to 5pm" required> <br>

        <label for="description">Work description</label><br>
        <textarea id="description" name="description" required rows="10" cols="40" style="height:200px" ></textarea><br>
           
        <label for="landmark">Landmark</label><br>
        <input type = "text" id="landmark" name="landmark" placeholder="Eg: Opposite to Copper Kitchen" required> <br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
        <input type="text"  id="captcha" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
        
        <button type="submit" onclick="return validationBooking()" name="submit" id="submit-button" style="border-radius:5px">Request Worker</button>
      </div> 
    </form>
  </body>
</html>