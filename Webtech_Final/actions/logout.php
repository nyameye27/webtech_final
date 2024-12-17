<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect the user to the homepage or login page after logging out
header("Location: ../view/Login.php");
exit();
?>