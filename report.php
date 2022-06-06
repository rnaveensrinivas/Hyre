<?php

session_start() ; 
include 'config.php' ; 

if( isset($_GET['ID']))
    $reportedID = $_GET['ID'] ;

if( isset($_SESSION['ID'])){
    if(isset($_POST['reportUser'])){ 

        $reportedID = $_POST['reportedID'] ;

        if( $reportedID == $_SESSION['ID']){
            echo"<script>alert('You cannot report yourself.')</script>" ;
        }
        else{

            $ID = $_SESSION['ID'] ; 
            $reportedID = $_POST['reportedID'] ;
            
            $query = "SELECT * FROM account WHERE ID = '$reportedID' " ; 
            $result = $conn->query($query) ; 

            if( $result->num_rows ){ // ($resultSet->num_rows != 0)
                //If there exist a team like that, then process.

                $row = mysqli_fetch_assoc($result) ; 
                $reportCount = $row['reportCount'] ; 

                $query = "update account set reportCount = reportCount + 1 where ID = '$reportedID'" ; 
                $result = $conn->query($query) ; 
                

                if( $reportCount > 6 ){
                    $query = "update account set accountStatus = 2 where ID = '$reportedID'" ; 
                    $result = $conn->query($query) ; 
                }

                $reportedID = $_POST['reportedID'] ; 
                $type = $_POST['type'] ;
                $description = $_POST['description'] ; 

                $query = "insert into report(reporterID, reportedID, type, description) values( '$ID', '$reportedID', '$type', '$description')" ; 
                $result = $conn->query($query) ; 


                echo"<script>alert('User has been reported. Redirecting to main lobby.')</script>" ; 
                echo"<script>document.location='mainlobby.php'</script>" ;
                
            }
            else{ 
                //echo mysqli_error($conn);
                $error = 'Invalid User ID. Try again.' ; 
                //echo"<script>document.location='jointeam.php'</script>" ; 
            }   
            $conn->close();

        }        
    }   
}
else{ 
    header("location:index.html") ; 
}

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Report</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
        
        <script src="1Level/validation.js"></script>
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
          
        <ul class="navbar-nav px-4  ms-auto"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="mainlobby.php">Lobby</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="jobRequests.php">Job Requests</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="upcomingJobs.php">Upcoming Jobs</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="jobHistory.php">Job History</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="logout.php">Sign out</a></li>
        </ul>
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>
        <form  action="" method="POST" autocomplete="off">
            <div class="form">

                <h2>Report User</h2>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>
            
                
                <label for="reportedID">User ID to report</label><br>
                <?php
                if( isset($_GET['ID'])){ ?>
                <input type="text" id="reportedID" name="reportedID" minlength="32" maxlength="32" required value='<?php echo $reportedID ?>' readonly >
                <?php }
                else{ ?>
                <input type="text" id="reportedID" name="reportedID" minlength="32" maxlength="32" required >
                <?php } ?>
                
                <label for="type" style="margin-top:20px">Reporting reason</label><br>
                <select name="type" id="type" style="width:100%; height:40px">
                <option value="Misbehave">Misbehave</option>
                <option value="Fake Account">Fake Account</option>
                <option value="Money Related" selected>Money Related</option>
                <option value="Punctuality Issue">Punctuality Issue</option>
                <option value="Other">Other</option>
                </select><br>

                <label for="description">Description of Report</label><br>
                <textarea id="description" name="description" required rows="10" cols="40" style="width:100%; height:200px; color: rgb(112, 112, 112);" ></textarea>
                
                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="margin-top:25px; border-radius:5px">New Captcha</button>
                <input type="text"  id="captcha" oncopy="return false" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" onpaste="return false" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
                
                <button type="submit" onclick="return checkCaptcha()" name="reportUser" id="submit-button" style="border-radius:5px">Report User</button>
                

                <script>
                    function validCaptcha(){ 
                        var captcha = document.getElementById('captcha').value ; 
                        var enteredCaptcha = document.getElementById('enteredCaptcha').value ; 
                        
                        if( enteredCaptcha == '' ){ 
                            alert("Enter the captcha.") ; 
                            return false ; 
                        }
                        else if( captcha != enteredCaptcha ){ 
                            alert("Wrong captcha Try again.") ; 
                            return false ; 
                        }
                    }
                </script>
            </div> 
        </form>
    </body>
</html>