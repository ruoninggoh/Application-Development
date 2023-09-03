<?php

    // Clear all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the sign-in page or any other desired page
    header("location: main.php");
    exit();
?>