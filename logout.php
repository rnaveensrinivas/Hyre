<?php 

session_start() ; 
unset($_SESSION['userType']) ; 
//unset($_SESSION['Password1']) ; 
//unset($_SESSION['FullName']) ; 
unset($_SESSION['phoneNumber']) ; 
//unset($_SESSION['TeamName']) ; 
//unset($_SESSION['studenttablename']) ; 
header('location:index.html') ;
session_close() ; 
?> 
