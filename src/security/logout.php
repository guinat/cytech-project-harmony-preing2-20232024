<?php
session_start();
session_unset();
session_destroy();
setcookie(session_name(), '', 100);

header('Location: ../../index.php');
exit;
