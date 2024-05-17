<?php

// Starting the session
session_start();

// Unsetting all session variables
session_unset();

// Destroying the session
session_destroy();

// Deleting the session cookie
setcookie(session_name(), '', 100);

// Redirecting to the sign-in page after session destruction
header('Location: ../pages/signIn.php');
exit;
