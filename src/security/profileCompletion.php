<?php
// Including the user entity file
require_once '../entity/user.php';
// Including utility functions
require_once '../utils/utils.php';

// Starting session to maintain user data across multiple pages
session_start();

try {
    // Checking if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Storing form values in session for re-populating the form on error
        $_SESSION['form_values'] = $_POST;

        // Retrieving user ID from session
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo 'User ID not found in session.';
            exit;
        }

        // Retrieving user details from the CSV file
        $user = getUserById($userId, '../data/users.csv');
        if (!$user) {
            throw new Exception('User not found.');
        }
        if ($user) {
            // Setting username in session
            $_SESSION['username'] = $user->getUsername();
        } else {
            throw new Exception('User not found.');
        }

        // Updating user information
        $user->setUpdatedAt(date('Y-m-d H:i:s'));
        $user->setFirstName(sanitizeInput($_POST['first_name'] ?? ''));
        $user->setLastName(sanitizeInput($_POST['last_name'] ?? ''));
        $user->setGender(sanitizeInput($_POST['gender'] ?? ''));
        $user->setDateOfBirth(sanitizeInput($_POST['birth_year']) . '-' . sanitizeInput($_POST['birth_month']) . '-' . sanitizeInput($_POST['birth_day']));
        $user->setCountry(sanitizeInput($_POST['country'] ?? ''));
        $user->setCity(sanitizeInput($_POST['city'] ?? ''));
        $user->setLookingFor(sanitizeInput($_POST['looking_for'] ?? ''));
        $user->setOccupation(sanitizeInput($_POST['occupation'] ?? ''));
        $user->setSmokingStatus(sanitizeInput($_POST['smoking'] ?? ''));
        $user->setHobbies(sanitizeInput($_POST['hobbies'] ?? ''));
        $user->setAboutMe(sanitizeInput($_POST['about_me'] ?? ''));
        $user->setMusicPreferences(sanitizeInput($_POST['selected_music'] ?? ''));

        // Uploading and updating user photos
        $uploadedPhotos = [];
        $uploadDir = '../data/photos/';
        $photoFields = ['photo1', 'photo2', 'photo3', 'photo4'];
        foreach ($photoFields as $photoField) {
            if (isset($_FILES[$photoField]) && $_FILES[$photoField]['error'] == UPLOAD_ERR_OK) {
                $fileName = $_SESSION['username'] . "_" . $photoField . ".png";
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES[$photoField]['tmp_name'], $filePath)) {
                    $uploadedPhotos[$photoField] = $filePath;
                }
            }
        }
        $user->setPhotos($uploadedPhotos);
        $_SESSION['user_photos'] = $user->getPhotos();
        $userPhotos = $user->getPhotos();

        // Setting data to update in the CSV file
        $dataToUpdate = [
            2 => $user->getUpdatedAt(),
            5 => 'ROLE_USER',
            6 => $user->getFirstName(),
            7 => $user->getLastName(),
            8 => $user->getGender(),
            9 => $user->getDateOfBirth(),
            10 => $user->getCountry(),
            11 => $user->getCity(),
            12 => $user->getLookingFor(),
            13 => $user->getMusicPreferences(),
            14 => $userPhotos['photo1'] ?? '',
            15 => $userPhotos['photo2'] ?? '',
            16 => $userPhotos['photo3'] ?? '',
            17 => $userPhotos['photo4'] ?? '',
            18 => $user->getOccupation(),
            19 => $user->getSmokingStatus(),
            20 => $user->getHobbies(),
            21 => $user->getAboutMe(),
            22 => '', // Subscription
            23 => '', // Subscription Start Date
            24 => '', // Subscription End Date
        ];

        // Updating user profile in the CSV file
        if (!updateUserProfile($userId, $dataToUpdate, '../data/users.csv')) {
            throw new Exception('Error updating data in CSV file.');
        }

        // Redirecting to the profile viewer page
        header('Location: /src/pages/profileViewer.php');
        exit();
    }
} catch (Exception $e) {
    // Setting error message in session and redirecting back to profile completion page on error
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: /src/pages/profileCompletion.php');
    exit;
}
