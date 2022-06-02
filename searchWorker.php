<?php
session_start() ; 
include 'config.php' ; 

if( $_SESSION['userType'] == "C" ){

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
          <li class="nav-item"><a class="nav-link" href="mainlobby.php">Lobby</a></li>
      </ul>
     
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="logout.php">Sign out</a></li>
        </ul>
        </div>
       
    </nav>
        
        <form method="POST" action="" autocomplete="off">
            <div class="form">
                <h2>Search Worker</h2>
                <p style="color:red; line-height: 120%;"> <?php echo $error ; ?></p>

                <div class="email">
                <label for="pincode">Pincode</label><br>
                <input type="number" id="pincode" name="pincode" min="600000" max="700000" placeholder="Eg: 600025" required><br>
                </div>

                <label for="jobType">Type of job</label><br>
                <select name="jobType" id="jobType" >
                <option value="NULL" selected hidden>Select an Option</option>
                <option value="Carpenter">Carpenter</option>
                <option value="Cook">Cook</option>
                <option value="Maid">Maid</option>
                <option value="Painter">Painter</option>
                </select><br>

                <label for="gender">Gender</label><br>
                <select name="gender" id="gender" style="margin-bottom:20px">
                <option value="NULL" selected hidden>Select an Option</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                </select>

                    <button type="submit" name="submit" id="submit-button" style="margin-top:20px ; border-radius:10px; width:30%; margin:auto; display:block;">Search</button>


            </div> 
        </form>
<?php



    if(isset($_POST['submit'])){ 

        $pincode = $_POST['pincode']; 
        $gender = $_POST['gender'];
        $jobType = $_POST['jobType']; 
        $isAvailableWorker = 0 ; 
        $checkPincodeIfExistsQuery = "SELECT * from tamilnadupincodes where pincode = '$pincode'" ; 
        $pincodeResult = mysqli_query( $conn , $checkPincodeIfExistsQuery ) ;

        if( $pincodeResult->fetch_assoc()){

            if( $gender == "NULL"){
                if( $jobType == "NULL"){
                    //should be changed to view.
                    $selectWorkers = "SELECT * FROM worker,account where worker.workerID=account.ID and pincode = '$pincode' ";
                }else{
                    $selectWorkers = "SELECT * FROM worker,account where worker.workerID=account.ID and pincode = '$pincode' and jobType = '$jobType' ";
                }
            }else{
                if( $jobType == "NULL"){
                    //should be changed to view.
                    $selectWorkers = "SELECT * FROM worker,account where worker.workerID=account.ID and pincode = '$pincode' and gender = '$gender' " ;
                }else{
                    $selectWorkers = "SELECT * FROM worker,account where worker.workerID=account.ID and pincode = '$pincode' and gender = '$gender' and jobType = '$jobType' ";
                }
            }
            if ( $result = mysqli_query( $conn, $selectWorkers ) ) { 
                while ( $row = mysqli_fetch_assoc($result) ) { 
                    $isAvailableWorker = 1 ;
                    $printName = $row['name'] ;
                    $printAverageRating = $row['averageRating'] ;
                    $printExperience = $row['experience'] ;
                    $workerID = $row['workerID'] ; 
                    echo "<div class='card' style='width:300px; margin: 20px; float:left'>" ;
                    echo "<div class='card-body' style='text-align:center; '>";
                    echo "<h5 class='card-title' >$printName</h5>"; 
                    echo "<p class='card-text' style='font-weight:300; font-size:1.25rem'>Average Rating: $printAverageRating<br>Experience: $printExperience</p>" ;
                    echo "<a href='workerProfile.php?workerID=$workerID' id='submit-button' style='text-decoration:none;'><button style='width:50%; border-radius:7px; margin:auto; display:block;'>View Worker</button></a></h3>" ;
                    echo "</div>" ;
                    echo "</div>" ;
                }

            }
            
            if( $isAvailableWorker == 0 ){

                echo "<div class='form'>" ;
                echo "<p>Sorry, no worker availble for entered pincode.</p>" ;
                echo "</div>" ;
            }
        }else{
            echo "<script>alert('This pincode is not in Tamil Nadu')</script>" ; 
        }
    }
    $conn->close();
}
else if( $_SESSION['userType'] == "W" ){
    header("location:mainlobby.php") ;
}
else{ 
    header("location:index.html") ; 
}
?>

    </body>
 </html> 



