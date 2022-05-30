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
    </head>

    <body>
        
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
                <button type="submit" name="submit" id="submit-button">Search</button>


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