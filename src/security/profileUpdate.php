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

        // Storing user data in session variables
        $_SESSION['email'] =  $_POST['email'];
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['first_name'] =  $_POST['first_name'];
        $_SESSION['last_name'] = $_POST['last_name'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['birth_year'] = $_POST['birth_year'];
        $_SESSION['birth_month'] = $_POST['birth_month'];
        $_SESSION['birth_day'] = $_POST['birth_day'];
        $_SESSION['date_of_birth'] = sanitizeInput($_POST['birth_year']) . '-' . sanitizeInput($_POST['birth_month']) . '-' . sanitizeInput($_POST['birth_day']);
        $_SESSION['country'] = $_POST['country'];
        $_SESSION['city'] = $_POST['city'];
        $_SESSION['looking_for'] = $_POST['looking_for'];
        $_SESSION['selected_music'] = $_POST['selected_music'];
        $_SESSION['occupation'] = $_POST['occupation'];
        $_SESSION['smoking_status'] = $_POST['smoking'];
        $_SESSION['hobbies'] = $_POST['hobbies'];
        $_SESSION['about_me'] = $_POST['about_me'];
        $_SESSION['subscription'] = '';
        $_SESSION['subscription_start_date'] = '';
        $_SESSION['subscription_end_date'] = '';

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

        // Retrieving user details from the CSV file
        $user = getUserById($userId, '../data/users.csv');
        if (!$user) {
            throw new Exception('User not found.');
        }
        $csvFile = '../data/users.csv';
        $userFound = false;

        // Checking if new password and confirm password match and updating user's password if necessary
        if ((!empty($newPassword)) && (!empty($confirmPassword)) && (!empty($currentPassword))) {
            if (empty($currentPassword) && (!password_verify($currentPassword, $data[5]))) {
                throw new Exception("Current password is missing or is incorrect.");
            }
            // Checking if the new password and confirm password match
            if ($newPassword !== $confirmPassword) {
                throw new Exception("Passwords do not match.");
            }
            if ($newPassword !== $confirmPassword) {
                throw new Exception("Passwords do not match.");
            }

            if (($handle = fopen($csvFile, 'r')) !== FALSE) {
                // Skipping the header row
                fgetcsv($handle);

                // Iterating through each row in the CSV file
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Checking if username matches and verifying the password
                    if ($data[4] === $username) {
                        if (password_verify($currentPassword, $data[5])) {
                            $userFound = true;
                            break;
                        } else {
                            fclose($handle);
                            throw new Exception("Current password is incorrect.");
                        }
                    }
                }
                fclose($handle);
                if (!$userFound) {
                    throw new Exception("User not found with given username.");
                }
            }
            // Setting new password for the user
            $user->setPassword($newPassword);

            if (!updateUserProfile($userId, $updatePasswordInDB, '../data/users.csv')) {
                throw new Exception('Error updating password in CSV file.');
            }
        }

        // Setting updated information for the user
        $user->setUpdatedAt(date('Y-m-d H:i:s'));
        $user->setEmail(sanitizeInput($_POST['email'] ?? ''));
        $user->setUsername(sanitizeInput($_POST['username'] ?? ''));
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

        // Supprimer les photos existantes de l'utilisateur
        foreach ($photoFields as $photoField) {
            $fileName = $_SESSION['username'] . "_" . $photoField . ".png";
            $filePath = $uploadDir . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Télécharger les nouvelles photos
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
            3 => $user->getEmail(),
            4 => $user->getUsername(),
            6 => 'ROLE_USER',
            7 => $user->getFirstName(),
            8 => $user->getLastName(),
            9 => $user->getGender(),
            10 => $user->getDateOfBirth(),
            11 => $user->getCountry(),
            12 => $user->getCity(),
            13 => $user->getLookingFor(),
            14 => $user->getMusicPreferences(),
            15 => $userPhotos['photo1'] ?? '',
            16 => $userPhotos['photo2'] ?? '',
            17 => $userPhotos['photo3'] ?? '',
            18 => $userPhotos['photo4'] ?? '',
            19 => $user->getOccupation(),
            20 => $user->getSmokingStatus(),
            21 => $user->getHobbies(),
            22 => $user->getAboutMe(),
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
