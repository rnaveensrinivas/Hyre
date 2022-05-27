<?php

session_start() ; 
include 'config.php' ; 

if( isset($_SESSION['CollegeID'])){
    if(isset($_POST['submit'])){ 

        $Keycode = $_POST['Keycode'] ;
        
        $query = "SELECT * FROM teams WHERE Keycode = '$Keycode' " ; 
        $result = $conn->query($query) ; 

        if( $result->num_rows ){ // ($resultSet->num_rows != 0)
            //If there exist a team like that, then process.

            $row = mysqli_fetch_assoc($result) ; 
            $TeamName = $row['TeamName'] ; 

            $tablename = $_SESSION['studenttablename'] ; 


            //Going to check if the student already enrolled in that particular team or not. 
            $query = "SELECT * FROM $tablename WHERE Keycode = '$Keycode' " ; 
            $result = $conn->query($query) ; 

            if( $result->num_rows ){
                //Student has already enrolled.
                echo"<script>alert('You have already enrolled in this team channel.Redirecting to main lobby.') </script>" ; 
                echo"<script>document.location='mainlobby.php'</script>" ;
            }
            else{
                $query = "INSERT INTO $tablename VALUES('$TeamName' , '$Keycode') " ; 
                $result = mysqli_query($conn, $query);

                if( $result ){ 
                    echo"<script>alert('Joined team succesfully.Redirecting to main lobby.') </script>" ; 
                    echo"<script>document.location='mainlobby.php'</script>" ;

                }else{ 
                    echo"<script>alert('Unable to join team. Try again Late.Redirecting to main lobby.')</script>" ; 
                    echo"<script>document.location='mainlobby.php'</script>" ;
                }   
            }  
        }
        else{ 
            //echo mysqli_error($conn);
            $error = 'Invalid Team Name. Try again.' ; 
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
        <title>Reset Password</title>
        <link rel="stylesheet" type="text/css" href="1Level/style2.css">
    </head>
    <body>
        <div class="logout">
            <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
        <form action="" method="POST" autocorrect="OFF">
            <div class="form">
                <h2>JoinTeam</h2>
                <p style="color:red; line-height: 120%; "> <?php  echo $error ; ?> </p>
                <div class="email">
                <label for="Keycode">Keycode : </label><br>
                <input type="Text" id="Keycode" name='Keycode' required ><br>
                </div>
                <button type="submit" name="submit" id="submit-button">Join Team</button>
            </div> 
        </form>
    </body>
 </html> 