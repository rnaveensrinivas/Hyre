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

if( $_SESSION['userType'] == "C" ){

    if(isset($_POST['withdrawRequest'])){ 
    
        $withdrawRequestQuery = "update job set bookingStatus = 3, jobStatus = 2 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $withdrawRequestQuery ) ){
            echo "<script>alert('Request for $workerID has been withdrawn. Redirecting you to job requests page.')</script>" ;
            header("location:jobRequests.php") ; 
        }else{
            echo "<script>alert('Unable to withdraw request for worker $workerID.')</script>" ;
        }
        $conn->close();

    }   
}
else if( $_SESSION['userType'] == "W" ){

    if( isset($_POST['acceptRequest'])){
        $acceptRequestQuery = "update job set bookingStatus = 1, jobStatus = 1 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $acceptRequestQuery ) ){
            echo "<script>alert('Request for $clientID accepted.')</script>" ;
            header("location:jobRequests.php") ; 
        }
    }
    else if( isset($_POST['rejectRequest'])){
        $rejectRequestQuery = "update job set bookingStatus = 2, jobStatus = 2 where jobID ='$jobID'" ;
        if( $result = mysqli_query( $conn, $rejectRequestQuery ) ){
            echo "<script>alert('Request for $clientID canceled.')</script>" ;
            header("location:jobRequests.php") ; 
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
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>Job Request</h2>

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

        <?php 



        if( $_SESSION['userType'] == "C" ){
        ?>
        <button type="submit" name="withdrawRequest" id="submit-button">Withdraw Request</button>
        <?php 
        }
        else
        if( $_SESSION['userType'] == "W" ){
        ?>
        <button type="submit" name="acceptRequest" id="submit-button">Accept</button>
        <button type="submit" name="rejectRequest" id="submit-button">Reject</button>
        <?php 
        }
        ?>
      </div> 
    </form>
  </body>
</html>