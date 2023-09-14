<?php
session_start();// Start the session
if( !isset($_SESSION['id'])){

    session_destroy();// Destroy the session
    header("location: ../view/inicioView.php");// Redirect to login page
}

?>