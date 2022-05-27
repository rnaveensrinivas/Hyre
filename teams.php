<?php
session_start() ; 
include 'config.php' ; 

if( isset($_SESSION['CollegeID'])){
    $teams = $_GET['TeamName'] ;
    $_SESSION['TeamName'] = $_GET['TeamName'] ; // This is for video calling. 

    if( $_SESSION['Category'] == "Teacher"){ 
        $getKeycode = "SELECT * FROM teams WHERE TeamName = '$teams'"; 
        $result = mysqli_query($conn , $getKeycode) ; 
        $row = $result->fetch_assoc() ; 
        $Keycode = $row['Keycode'] ; 
    }

    $PrintTeamName = substr($teams,0,-11) ;
    $conn->close();
}
else{ 
    header("location:index.html") ; 
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $PrintTeamName; ?></title>
        <link rel="stylesheet" type="text/css" href="1Level/style2.css">
    </head>

    <body>
        <div class="logout">
            <button type="button" onclick="location.href='logout.php'" name="Logout" id="submit-button" style="background-color: white; color:rgb(95, 108, 255);">Sign Out</button>
        </div>
        <div class="form">
            <h2>Welcome to <?php echo $PrintTeamName; ?> </h2>
            <p style="line-height:120%;"> To allow users to join this channel refer below <br>KeyCode: <?php if( $_SESSION['Category'] == "Teacher"){echo $Keycode ;}?> </p>
            <button type="button" onclick="location.href='2Video/video.php'" id="submit-button" style="width:50% ; height:100% ; float:right; " >Video Call</button>
            <a href="https://60ea725ba5133508bfa1b273--ecstatic-galileo-ebbce8.netlify.app/"> <button type="button"  id="submit-button" style="width:50% ; height:100% ; float:left; " >Group Chat</button></a>
        </div>
    </body>
 </html> 