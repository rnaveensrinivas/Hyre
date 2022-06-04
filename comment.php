<?php

session_start() ; 
include 'config.php' ; 

if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
}else{
  header("location:mainlobby.php") ;
}

if( isset($_GET['jobID'] ) ){ 
    $jobID = $_GET['jobID'] ; 
}else{
  header("location:mainlobby.php") ;
}


if( $_SESSION['userType'] == "C" ){

  $clientID = $_SESSION['ID'] ;
  $isExistingAccountQuery = "SELECT * FROM job WHERE jobID = '$jobID' LIMIT 1" ;
  $resultSet = $conn->query($isExistingAccountQuery) ; 
    
  if( $resultSet->num_rows ){ 

    $row = $resultSet->fetch_assoc() ; 

    $workerName = $row['workerName'] ; 
    $clientName = $row['clientName'] ;
    $checkWorkerID = $row['workerID'] ;
    $checkClientID = $row['clientID'] ;

    if( $checkWorkerID != $workerID || $checkClientID != $clientID ){
      header("location:mainlobby.php") ;
    }

    if(isset($_POST['submit'])){ 

      $workerID = $_POST['workerID'] ; 
      $rating = $_POST['rating'] ;
      $description = $_POST['description'] ;
      
      $insertCommentQuery = "insert into comment(jobID, workerID, workerName, clientID, clientName, rating , description) values('$jobID', '$workerID', '$workerName' , '$clientID', '$clientName' , '$rating' ,'$description') "  ; 
      $result = $conn->query($insertCommentQuery) ;
      if( $result ){ 
        
        $searchWorkerQuery = "select * from worker where workerID = '$workerID' LIMIT 1"  ; 
        $result = $conn->query($searchWorkerQuery) ;
        $row = $result->fetch_assoc() ;

        $averageRating = $row['averageRating'] ;
        $ratingCount = $row['ratingCount'] ;

        $totalRating = $averageRating * $ratingCount ;
        $totalRating = $totalRating + $rating ; 
        $ratingCount = $ratingCount + 1 ; 
        $averageRating = $totalRating / $ratingCount ;

        $updateWorkerRatingQuery = "update worker set averageRating = '$averageRating' , ratingCount = '$ratingCount' where workerID = '$workerID' " ; 
        $result = $conn->query($updateWorkerRatingQuery) ;

        echo"<script>document.location='workerProfile.php?workerID=$workerID'</script>" ;
      }else{ 
        echo"<script>alert('Unable to make comment at this moment.') </script>" ; 
      }  
    }
    $conn->close();  
  }else{
    header("location:mainlobby.php");
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
    <title>Comment</title>
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
          <ul class="navbar-nav px-4"> 
            <li class="nav-item"><a class="nav-link" href="logout.php">Sign Out</a></li>
          </ul>
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>Comment</h2>
        <p><?php echo $error ; ?></p>
            
        <div class="fname">
          <label for="workerName">Worker Name</label><br>
          <input type = "text" id="workerName" name="workerName"  value='<?php echo $workerName ?>' required readonly> <br>
        </div>
        <div class="fname">
          <label for="workerID">Worker ID</label><br>
          <input type = "text" id="workerID" name="workerID"  value='<?php echo $workerID ?>' required readonly> <br>
        </div>
        
        <label for="rating" >Rating</label><br>
        <select name="rating" id="rating" style="width:100%; height:40px" required>
        <option value=1>1</option>
        <option value=2>2</option>
        <option value=3>3</option>
        <option value=4>4</option>
        <option value=5 selected>5</option>
        </select><br>

        <label for="description">Comment Description</label><br>
        <textarea id="description" name="description" required rows="10" cols="40"style="width:100%; height:200px" ></textarea><br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="margin-top:25px; border-radius:5px">New Captcha</button>
        <input type="text"  id="captcha" oncopy="return false" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" onpaste="return false" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

        <button type="submit" onclick="return checkCaptcha()" name="submit" id="submit-button" style="border-radius:5px">Comment</button>
        
        

      </div> 
    </form>
  </body>
</html>