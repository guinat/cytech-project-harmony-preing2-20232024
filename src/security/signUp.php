<?php
require_once '../entity/user.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header('Location: /src/pages/signUp.php');
        exit;
    }

    try {
        $user = createUser($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();

            header('Location: /src/pages/profileCompletion.php');
            exit;
        } else {
            $_SESSION['error_message'] = "Error during registration.";
            header('Location: /src/pages/signUp.php');
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: /src/pages/signUp.php');
        exit;
    }
}
