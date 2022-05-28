<?php

session_start() ; 
include 'config.php' ; 

if( isset($_SESSION['ID'])){
    if(isset($_POST['reportUser'])){ 

        
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

            $query = "insert into report values( '$ID', '$reportedID', '$type', '$description')" ; 
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
else{ 
    header("location:index.html") ; 
}

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Report</title>
        <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
        <script src="1Level/validation.js"></script>
    </head>

    <body onload="newCaptcha()">
        <form  action="" method="POST" autocomplete="off">
            <div class="form">

                <h2>(to be filled)</h2>
                <p>(to be filled)</p>

                <p style="color:red; line-height: 120%; "><?php echo $error ; ?></p>
            
                
                <label for="reportedID">User ID to report</label><br>
                <input type="text" id="reportedID" name="reportedID" minlength="32" maxlength="32" required >
                <!--<a href="resetpassword.php" style="text-decoration:none; font-size: 15px;">Forgot Password?</a><br><br> -->

                <label for="type">Reporting reason</label><br>
                <select name="type" id="type">
                <option value="Assault">Assault</option>
                <option value="Money Related">Money Related</option>
                <option value="Other">Other</option>
                </select><br>

                <label for="description">Description of Report</label><br>
                <textarea id="description" name="description" required rows="10" cols="40" ></textarea>
                
                <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha.">New Captcha</button>
                <input type="text"  id="captcha" class="searchBox" readonly>
                <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>

                <!-- Below validate captcha is not working. -->
                <button type="submit" onclick="return validCaptcha()" name="reportUser" id="submit-button">Report User</button>
                

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