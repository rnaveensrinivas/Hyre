<?php

session_start() ; 
include 'config.php' ; 

$workerID = "" ;
$clientID = "" ;
$jobID = "" ; 

if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
}else{
    header("location:jobRequests.php") ; 
}

if( isset($_GET['clientID'] ) ){ 
    $clientID = $_GET['clientID'] ; 
}else{
    header("location:jobRequests.php") ; 
}

if( isset($_GET['jobID'] ) ){ 
    $jobID = $_GET['jobID'] ; 
}else{
    header("location:jobRequests.php") ; 
}

if( isset($_GET['bookingStatus']) && $_GET['bookingStatus'] == 0 ){ 
    
}else{
    header("location:jobRequests.php") ;
}

$selectAllRequests = "SELECT * FROM job where jobID = '$jobID'" ; 
$result = mysqli_query( $conn, $selectAllRequests ) ;
$row = mysqli_fetch_assoc($result) ;

$landmark = $row['landmark'] ; 
$pincode = $row['pincode'] ; 
$time = $row['time'] ; 
$date = $row['date'] ;
$workType = $row['workType'] ;
$description =  $row['description'] ; 
$bookingStatus = $row['bookingStatus'] ; 
$clientName = $row['clientName'] ; 
$workerName = $row['workerName'] ; 


if( $bookingStatus != 0 ){
  header("mainlobby.php") ;
}

if( $_SESSION['userType'] == "C" ){

    if(isset($_POST['withdrawRequest'])){ 
    
      $selectAllRequests = "SELECT * FROM job where jobID = '$jobID'" ; 
      $result = mysqli_query( $conn, $selectAllRequests ) ;
      $row = mysqli_fetch_assoc($result) ;
      $bookingStatus = $row['bookingStatus'] ; 
      $jobStatus = $row['jobStatus'] ;
      
      if( $bookingStatus == 0 && $jobStatus == 0 ){
        $withdrawRequestQuery = "update job set bookingStatus = 3, jobStatus = 2 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $withdrawRequestQuery ) ){
            echo "<script>alert('Request for $workerID has been withdrawn. Redirecting you to job requests page.')</script>" ;
            header("location:jobRequests.php") ; 
        }else{
            echo "<script>alert('Unable to withdraw request for worker $workerID.')</script>" ;
        }
        $conn->close();
      }else{
        echo "<script>alert('This request has been modified by the worker. Unable to withdraw request for worker $workerID. Go to lobby.')</script>" ;
      }

    }   
}
else if( $_SESSION['userType'] == "W" ){

    if( isset($_POST['acceptRequest'])){
      $selectAllRequests = "SELECT * FROM job where jobID = '$jobID'" ; 
      $result = mysqli_query( $conn, $selectAllRequests ) ;
      $row = mysqli_fetch_assoc($result) ;
      $bookingStatus = $row['bookingStatus'] ; 
      $jobStatus = $row['jobStatus'] ;
      
      if( $bookingStatus == 0 && $jobStatus == 0 ){
        $acceptRequestQuery = "update job set bookingStatus = 1, jobStatus = 1 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $acceptRequestQuery ) ){
            echo "<script>alert('Request for $clientID accepted.')</script>" ;
            header("location:jobRequests.php") ; 
        }
      }
      else{
        echo "<script>alert('This request has been withdrawn by the Client. Unable to accept request for client $clientID. Go to lobby.')</script>" ;
      }
    }
    else if( isset($_POST['rejectRequest'])){
      $selectAllRequests = "SELECT * FROM job where jobID = '$jobID'" ; 
      $result = mysqli_query( $conn, $selectAllRequests ) ;
      $row = mysqli_fetch_assoc($result) ;
      $bookingStatus = $row['bookingStatus'] ; 
      $jobStatus = $row['jobStatus'] ;
      
      if( $bookingStatus == 0 && $jobStatus == 0 ){
        $rejectRequestQuery = "update job set bookingStatus = 2, jobStatus = 2 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $rejectRequestQuery ) ){
            echo "<script>alert('Request for $clientID canceled.')</script>" ;
            header("location:jobRequests.php") ; 
        }
      }
      else{
        echo "<script>alert('This request has been withdrawn by the Client. Unable to reject request for client $clientID. Go to lobby.')</script>" ;
      }
    }

    $conn->close();

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
    <script src="1Level/validation.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    

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
            <li class="nav-item"><a class="nav-link" href='mainlobby.php'>Lobby</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href='logout.php'>Sign out</a></li>
        </ul>
        </div>
       
    </nav>
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>Job Request</h2>

        <?php 
        if( $_SESSION['userType'] == "C" ){
        ?>
        <div class="fname">
          <label for="workerName">Worker Name</label><br>
          <input type = "text" id="workerName" name="workerName" value='<?php echo $workerName ?>'readonly> <br>
        </div>
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
          <label for="clientName">Client Name</label><br>
          <input type = "text" id="clientName" name="clientName" value='<?php echo $clientName ?>'readonly> <br>
        </div>
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

        <?php 



        if( $_SESSION['userType'] == "C" ){
        ?>
        <button type="submit" name="withdrawRequest" id="submit-button">Withdraw Request</button>
        <?php 
        }
        else
        if( $_SESSION['userType'] == "W" ){
        ?>
        <button type="submit" name="acceptRequest" id="submit-button" style="margin-top:5px">Accept</button>
        <button type="submit" name="rejectRequest" id="submit-button" style="margin-top:15px">Reject</button>
        <?php 
        }
        ?>
      </div> 
    </form>
  </body>
</html>