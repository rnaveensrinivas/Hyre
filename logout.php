<?php 

session_start() ; 
unset($_SESSION['CollegeID']) ; 
//unset($_SESSION['Password1']) ; 
//unset($_SESSION['FullName']) ; 
unset($_SESSION['Category']) ; 
//unset($_SESSION['TeamName']) ; 
//unset($_SESSION['studenttablename']) ; 
header('location:index.html') ;
session_close() ; 
?> 
