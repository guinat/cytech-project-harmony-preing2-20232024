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
            throw new Exception('User ID not found in session.');
        }

        // Retrieving username, current password, new password, and confirm password from POST data
        $username = $_POST['username'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new-password'];
        $confirmPassword = $_POST['confirm-password'];

        // Checking if new password and confirm password match and updating user's password if necessary
        if (!empty($newPassword) && !empty($confirmPassword)) {
            if ($newPassword !== $confirmPassword) {
                throw new Exception("Passwords do not match.");
            }
            // Setting new password for the user
            $user->setPassword($newPassword);
        }

        // Retrieving user details from the CSV file
        $user = getUserById($userId, '../data/users.csv');
        if (!$user) {
            throw new Exception('User not found.');
        }

        // Checking if the current password matches the one stored in the CSV file
        $csvFile = '../data/users.csv';
        $userFound = false;
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            // Skipping the header row
            fgetcsv($handle);

            // Iterating through each row in the CSV file
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Checking if username matches and verifying the password
                if ($data[3] === $username) {
                    if (password_verify($currentPassword, $data[4])) {
                        $userFound = true;
                        break;
                    } else {
                        fclose($handle);
                        throw new Exception("Current password is incorrect.");
                    }
                }
            }
            fclose($handle);
        }

        // Handling the case where user is not found with the given username
        if (!$userFound) {
            throw new Exception("User not found with given username.");
        }

        // Setting updated information for the user
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
            $photoKey = $photoField;
            if (isset($_FILES[$photoKey]) && $_FILES[$photoKey]['error'] == UPLOAD_ERR_OK) {
                $fileName = $_SESSION['username'] . "_" . $photoKey . ".png";
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES[$photoKey]['tmp_name'], $filePath)) {
                    $uploadedPhotos[$photoKey] = $filePath;
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
            22 => '0'
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
    // Setting error message in session and redirecting back to profile update page on error
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: /src/pages/profileUpdate.php');
    exit;
}
