<?php

session_start() ; 
include 'config.php' ; 

$workerID = "" ;
$clientID = "" ;
$jobID = "" ; 

if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
}else{
    header("location:upcomingJobs.php") ; 
}

if( isset($_GET['clientID'] ) ){ 
    $clientID = $_GET['clientID'] ; 
}else{
    header("location:upcomingJobs.php") ; 
}

if( isset($_GET['jobID'] ) ){ 
    $jobID = $_GET['jobID'] ; 
}else{
    header("location:upcomingJobs.php") ; 
}

if( isset($_GET['jobID']) && $_GET['jobStatus'] == 1 ){ 
    $jobID = $_GET['jobID'] ; 
}else{
    header("location:upcomingJobs.php") ; 
}

$selectThatJobQuery = "SELECT * FROM job where jobID = '$jobID'" ; 
$result = mysqli_query( $conn, $selectThatJobQuery ) ;
$row = mysqli_fetch_assoc($result) ;

$landmark = $row['landmark'] ; 
$pincode = $row['pincode'] ; 
$time = $row['time'] ; 
$date = $row['date'] ;
$workType = $row['workType'] ;
$description =  $row['description'] ; 

if( $_SESSION['userType'] == "C" ){

    if(isset($_POST['cancelJob'])){ 
    
        $cancelJobQuery = "update job set jobStatus = 4 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $cancelJobQuery ) ){
            echo "<script>alert('Booked Job for $workerID cancelled. Redirecting to upcoming jobs page.')</script>" ;
            header("location:upcomingJobs.php") ;
        }else{
            echo "<script>alert('Unable to cancel request for worker $workerID.')</script>" ;
        }
        $conn->close();

    }   
}
else if( $_SESSION['userType'] == "W" ){

    if(isset($_POST['cancelJob'])){ 
        $cancelJobQuery = "update job set jobStatus = 3 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $cancelJobQuery ) ){
            echo "<script>alert('Booked Job for $clientID cancelled. Redirecting to upcoming jobs page.')</script>" ;
            header("location:upcomingJobs.php") ;
        }else{
            echo "<script>alert('Unable to cancel request for worker $clientID.')</script>" ;
        }
        $conn->close();
    }

}
else{ 
    header("location:index.html") ; 
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Upcoming Job </title>
    <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    <script src="1Level/validation.js"></script>
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>Upcoming Job</h2>

        <?php 
        if( $_SESSION['userType'] == "C" ){
        ?>
        <div class="fname">
          <label for="workerID">Worker ID</label><br>
          <input type = "text" id="workerID" name="workerID" value='<?php echo $workerID ?>'readonly> <br>
        </div>
        <?php 
        }
        ?>

        <?php 
        if( $_SESSION['userType'] == "W" ){
        ?>
        <div class="fname">
          <label for="clientID">Client ID</label><br>
          <input type = "text" id="clientID" name="clientID" value='<?php echo $clientID ?>'readonly> <br>
        </div>
        <?php 
        }
        ?>

        <div class="fname">
          <label for="landmark">Landmark</label><br>
          <input type = "text" id="landmark" name="landmark" value='<?php echo $landmark ?>'readonly> <br>
        </div>

        <div class="fname">
          <label for="pincode">Pincode</label><br>
          <input type = "text" id="pincode" name="pincode" value='<?php echo $pincode ?>'readonly> <br>
        </div>

        <div class="fname">
          <label for="time">Time</label><br>
          <input type = "text" id="time" name="time" value='<?php echo $time ?>'readonly> <br>
        </div>

        <div class="fname">
          <label for="date">Date</label><br>
          <input type = "text" id="date" name="date" value='<?php echo $date ?>'readonly> <br>
        </div>


        <label for="description">Work description</label><br>
        <textarea id="description" name="description" required rows="10" cols="40" readonly><?php echo $description ?></textarea><br>

       
        <button type="submit" name="cancelJob" id="submit-button">Cancel Job</button>
      </div> 
    </form>
  </body>
</html>