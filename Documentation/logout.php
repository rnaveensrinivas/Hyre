<?php 
session_start() ; 
unset($_SESSION['userType']) ; 
unset($_SESSION['phoneNumber']) ; 
unset($_SESSION['ID']) ; 
header('location:index.html') ;
session_close() ; 
?> 
