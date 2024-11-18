<?php 
    session_start(); 
    // remove sesion4
    unset($_SESSION['sesion4']);
  
    header('location: ../vista/index.php'); 
?>    
  