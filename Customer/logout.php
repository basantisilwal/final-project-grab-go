<?php
session_start(); // Start the session

// Destroy all sessions
session_unset();
session_destroy();

// Redirect to the homepage
header("Location: ../index.php");
exit();
?>
