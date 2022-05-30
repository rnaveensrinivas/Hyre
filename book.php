<?php

session_start() ; 
include 'config.php' ; 

$workerID ="" ;
if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
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
            $workType = $_POST['workType'] ;
            $date = $_POST['date'] ; 
            $time = $_POST['time'] ; 
            $description = $_POST['description'] ;
            $pincode = $_POST['pincode'] ; 
            $landmark = $_POST['landmark'] ; 
            $clientID = $_SESSION['ID'] ;

            $query = "insert into job(clientID, workerID, landmark, pincode, time, date, workType, description,bookingStatus, jobStatus, clientRating, workerRating) values('$clientID', '$workerID', '$landmark' , '$pincode', '$time', '$date', '$workType', '$description', 0 , 0 , 0 , 0 )" ; 
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
    <title>Request</title>
    <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    <script src="1Level/validation.js"></script>
  </head>


  <body onload="newCaptcha()">
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>(to be filled)</h2>
        <p>(to be filled)</p>
        
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

        <label for="workType">Job</label><br>
        <select name="workType" id="workType" required>
        <option value="Carpentry">Carpenter</option>
        <option value="Cook">Cook</option>
        <option value="Other">Other</option>
        </select><br>

        <label for="date">Date of Job</label><br>
        <input type="date" id="date" name="date" reqired><br>

        <label for="time">Time of Job</label><br>
        <input type = "text" id="time" name="time" placeholder="Eg: 3pm to -5pm" required> <br>

        <label for="description">Work description</label><br>
        <textarea id="description" name="description" required rows="10" cols="40" ></textarea><br>
           
        <label for="pincode">Pincode</label><br>
        <input type="number" id="pincode" name="pincode" min="100000" max="999999" placeholder="Eg: 600025"><br>

        <label for="landmark">Landmark</label><br>
        <input type = "text" id="landmark" name="landmark" placeholder="Eg: Opposite to Copper Kitchen" required> <br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
        <input type="text"  id="captcha" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
        
        <button type="submit" onclick="return validCaptcha()" name="submit" id="submit-button">Request Worker</button>
      </div> 
    </form>
  </body>
</html>