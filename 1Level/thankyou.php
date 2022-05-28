<?php

if($_GET['Status'] != "success"){ 
    header("location: ../index.html") ; 
}

?>

<!doctype html>
<html>
    <head>
        <title>Thank You</title>
        <link href="darkTheme.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <div style="text-align:center; margin:5%">
            <h1 style="color:white;">Thank you. Go Login Now.</h1>
            <input type="button" id="submit-button" onclick="location.href='login.php';" value="Login" />
        </div>
        
    </body>
</html>