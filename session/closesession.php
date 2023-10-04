<?php
    session_start();//start the session
    // ! Destroys the session
    session_destroy();//destroy the session
    // ! Redirects to the login page
    header("location: ../index.php");//redirect to login page
?>
