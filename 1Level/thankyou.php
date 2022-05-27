<?php

if($_GET['Status'] != "Sent"){ 
    header("location:../index.html") ; 
}

?>

<!doctype html>
<html>
    <head>
        <title>Thank You</title>
        <link href="style2.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <div style="text-align:center; margin:5%">
            <h1 style="color:white;">Thank you. Go check your inbox.</h1>
            <img src="envelope.png" width="20%" >
        </div>
        
    </body>
</html>