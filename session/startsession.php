<?php
session_start();//start the session

if(!isset($_SESSION['id'])){//if session not found redirect to login page

    session_destroy();//destroy the session
    header("location: ../index.php");//redirect to login page
}

?>