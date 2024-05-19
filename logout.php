<?php
session_start();
session_destroy(); // Destroy all sessions

// Redirect to the login page after logout
header("Location: login.php");
exit();
?>
