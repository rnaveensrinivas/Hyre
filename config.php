<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduvate";

$conn = NEW mysqli($servername, $username, $password, $dbname);
// Checking connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}
$error = "" ; 
?>