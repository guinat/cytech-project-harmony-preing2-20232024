<?php
session_start();
require_once '../entity/user.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $csvFile = '../data/users.csv';
    $userFound = false;

    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[1] === $username && password_verify($password, $data[2])) {
                $userFound = true;
                $_SESSION['user_id'] = $data[0];
                $_SESSION['username'] = $username;
                break;
            }
        }
        fclose($handle);
    }

    if ($userFound) {
        header('Location: /src/pages/app.php');
        exit;
    } else {
        $_SESSION['error_message'] = 'Incorrect credentials.';
        header('Location: /src/pages/signIn.php');
        exit;
    }
}
