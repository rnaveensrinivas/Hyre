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
            <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
          <li class="nav-item"><a class="nav-link" href="">Contact</a></li>
      </ul>
     
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="">Sign out</a></li>
        </ul>
        </div>
       
    </nav>
        <div class="logout">
            <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
        <form method="POST" action="" autocomplete="off">
            <div class="form">
                <h2>(to be filled)</h2>
                <p style="color:red; line-height: 120%;"> <?php echo $error ; ?></p>

                <div class="email">
                <label for="pincode">Pincode</label><br>
                <input type="number" id="pincode" name="pincode" min="100000" max="999999" placeholder="Eg: 600025" required><br>
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
                <select name="gender" id="gender">
                <option value="NULL" selected hidden>Select an Option</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Other</option>
                </select>
                <button type="submit" name="submit" id="submit-button" style="margin-top:20px">Search</button>


            </div> 
        </form>
<?php



    if(isset($_POST['submit'])){ 



        $pincode = $_POST['pincode']; 
        $gender = $_POST['gender'];
        $jobType = $_POST['jobType']; 

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
                $printName = $row['name'] ;
                $printAverageRating = $row['averageRating'] ;
                $printExperience = $row['experience'] ;
                $workerID = $row['workerID'] ; 
                echo "<div class='form'>" ;
                echo "<h3>Name : $printName "; 
                echo "<p>Average Rating : $printAverageRating<br>Experience : $printExperience</p>" ;
                echo "<a href='workerProfile.php?workerID=$workerID' id='submit-button'><button>Worker Profile</button></a></h3>" ;
                echo "</div>" ;
               
            }
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