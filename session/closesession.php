<?php
    session_start();//start the session
    // ! Se destruye la sesión y se redirige al login
    session_destroy();//destroy the session
    // ! Se redirige al login

    header("location: ../index.php");//redirect to the login.php page
?>