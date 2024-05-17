<?php
// Including the user entity file
require_once '../entity/user.php';

// Starting session for user interaction tracking or other session-based functionality
session_start();

// Checking if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving username, password, and confirm password from the POST data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Checking if the password and confirm password match
    if ($password !== $confirmPassword) {
        // Setting an error message in the session
        $_SESSION['error_message'] = "Passwords do not match.";
        // Redirecting back to the sign-up page
        header('Location: /src/pages/signUp.php');
        // Exiting the script
        exit;
    }

    try {
        // Creating a new user with the provided username and password
        $user = createUser($username, $password);

        if ($user) {
            // If user creation is successful, storing user details in session
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();

            // Redirecting to the profile completion page
            header('Location: /src/pages/profileCompletion.php');
            // Exiting the script
            exit;
        } else {
            // If user creation fails, setting an error message in the session
            $_SESSION['error_message'] = "Error during registration.";
            // Redirecting back to the sign-up page
            header('Location: /src/pages/signUp.php');
            // Exiting the script
            exit;
        }
    } catch (Exception $e) {
        // Catching any exceptions that occur during the user creation process
        // Setting the error message in the session
        $_SESSION['error_message'] = $e->getMessage();
        // Redirecting back to the sign-up page
        header('Location: /src/pages/signUp.php');
        // Exiting the script
        exit;
    }
}
