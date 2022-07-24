<?php

//if someone tries to access this page directly. It won't permit. This can be accessed only after signup is successful.
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
            <h3>Thank you. Kindly login now.</h3>
            <input type="button" id="submit-button" onclick="location.href='login.php';" value="Login" style="width:10%"/>
        </div>
        
    </body>
</html>