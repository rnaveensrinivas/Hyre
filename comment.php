<?php

session_start() ; 
include 'config.php' ; 

$workerID ="" ;
if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
}

$jobID = 0 ;
if( isset($_GET['jobID'] ) ){ 
    $jobID = $_GET['jobID'] ; 
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
            $description = $_POST['description'] ;
            $jobID = $_POST['jobID'] ;
            $clientID = $_SESSION['ID'] ;
            echo $workerID . "-------" ;
            echo $clientID . "-------" ;
            echo $description . "-------" ;
            echo $jobID ;
            //not working.
            $insertCommentQuery = "INSERT INTO comment (jobID, workerID, clientID, description) values($jobID, '$workerID', '$clientID', '$description') "  ; 
            $in = "insert into comment values(1,'sdff','asdf',adf') ";
            $result2 = $conn->query($insertCommentQuery) ;
            echo("Error description: " . $conn->error);
            if( $result2  ){ 
                echo "hellw" ;
                echo"<script>alert('Comment made successfully. Redirecting to worker's profile.') </script>" ; 
                echo"<script>document.location='workerProfile.php?workerID=$workerID'</script>" ;

            }else{ 
                echo"<script>alert('Comment made successfully. Redirecting to worker's profile.') </script>" ; 
                //echo"<script>alert('Unable to make a comment. Try again Late.Redirecting to main lobby.')</script>" ; 
                //echo"<script>document.location='mainlobby.php'</script>" ;
            }  

        }
        else{ 
            //echo mysqli_error($conn);
            $error = 'Invalid workerID. Try again.' ; 
            //echo"<script>document.location='jointeam.php'</script>" ; 
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
    <title>Comment</title>
    <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    <script src="1Level/validation.js"></script>
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>(to be filled)</h2>
        <p><?php echo $error ; ?></p>
        
        <!--
        <div class="email">
          <label for="em">E-mail</label><br>
          <input type = "email" id="em" name="em" required placeholder="abcd@gmail.com"><br>
        </div>
        -->
            
        <div class="fname">
          <label for="workerID">Worker ID</label><br>
          <input type = "text" id="workerID" name="workerID" placeholder="Eg: fhsd8sfdfkj242Gsf23423" value='<?php echo $workerID ?>' required readonly> <br>
        </div>
        <div class="fname">
          <label for="jobID">job ID</label><br>
          <input type = "text" id="jobID" name="jobID"  value='<?php echo $jobID ?>' required readonly> <br>
        </div>

        <label for="description">Comment Description</label><br>
        <textarea id="description" name="description" required rows="10" cols="40" ></textarea><br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
        <input type="text"  id="captcha" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
        
        <button type="submit" onclick="return validCaptcha()" name="submit" id="submit-button">Submit Comment</button>
        
        

      </div> 
    </form>
  </body>
</html>