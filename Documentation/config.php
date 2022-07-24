<?php
$serverName = "localhost";
$username = "root";
$password = "";
$databaseName = "hyre";

$conn = NEW mysqli($serverName, $username, $password, $databaseName);
// Checking connection
if( $conn->connect_error ){
        die("Connection failed: " . $conn->connect_error);
}
$error = "" ; 
?>