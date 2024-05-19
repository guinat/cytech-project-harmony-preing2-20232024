<?php
// Starting session to maintain user data across multiple pages
session_start();

// Including the user entity file
require_once '../entity/user.php';

// Checking if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieving username and password from the POST data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Path to the CSV file containing user data
    $csvFile = '../data/users.csv';

    // Flag to indicate if user is found
    $userFound = false;

    // Opening the CSV file for reading
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        // Getting the header row
        $header = fgetcsv($handle);

        // Iterating through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Checking if username and password match
            if ($data[4] === $username && password_verify($password, $data[5])) {
                // Setting user found flag to true
                $userFound = true;

                print_r($data);

                // Storing user data in session variables
                $_SESSION['user_id'] = $data[0];
                $_SESSION['email'] = $data[3];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $data[6];
                $_SESSION['first_name'] = isset($data[7]) ? $data[7] : '';
                $_SESSION['last_name'] = isset($data[8]) ? $data[8] : '';
                $_SESSION['gender'] = isset($data[9]) ? $data[9] : '';
                $_SESSION['date_of_birth'] = isset($data[10]) ? $data[10] : '';
                $_SESSION['country'] = isset($data[11]) ? $data[11] : '';
                $_SESSION['city'] = isset($data[12]) ? $data[12] : '';
                $_SESSION['looking_for'] = isset($data[13]) ? $data[13] : '';
                $_SESSION['selected_music'] = isset($data[14]) ? $data[14] : '';
                $_SESSION['user_photos'] = array_slice($data, 15, 4);
                $_SESSION['occupation'] = isset($data[19]) ? $data[19] : '';
                $_SESSION['smoking_status'] = isset($data[20]) ? $data[20] : '';
                $_SESSION['hobbies'] = isset($data[21]) ? $data[21] : '';
                $_SESSION['about_me'] = isset($data[22]) ? $data[22] : '';
                $_SESSION['subscription'] = isset($data[23]) ? $data[23] : '';
                $_SESSION['subscription_start_date'] = isset($data[24]) ? $data[24] : '';
                $_SESSION['subscription_end_date'] = isset($data[25]) ? $data[25] : '';

                // Exiting the loop since user is found
                break;
            }
        }
        // Closing the CSV file
        fclose($handle);
    }

    // Redirecting based on whether user is found or not
    if ($userFound) {
        // Redirecting to the application page
        header('Location: /src/pages/app.php');
        // Exiting the script
        exit;
    } else {
        // Setting error message if user is not found
        $_SESSION['error_message'] = 'Incorrect credentials.';
        // Redirecting back to the sign-in page
        header('Location: /src/pages/signIn.php');
        // Exiting the script
        exit;
    }
}
