<?php
require_once '../entity/user.php';
require_once '../utils/utils.php';

session_start();
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $_SESSION['form_values'] = $_POST;

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            echo 'User ID not found in session.';
            exit;
        }

        $user = getUserById($userId, '../data/users.csv');
        if (!$user) {
            throw new Exception('User not found.');
        }
        if ($user) {
            $_SESSION['username'] = $user->getUsername();
        } else {
            throw new Exception('User not found.');
        }

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
        $userPhotos = $user->getPhotos();


        $dataToUpdate = [
            2 => $user->getUpdatedAt(),
            5 => 'ROLE_USER',  // Role
            6 => $user->getFirstName(), // First Name
            7 => $user->getLastName(), // Last Name
            8 => $user->getGender(), // Gender
            9 => $user->getDateOfBirth(), // Date of Birth
            10 => $user->getCountry(), // Country
            11 => $user->getCity(), // City
            12 => $user->getLookingFor(), // Looking For
            13 => $user->getMusicPreferences(), // Music Preferences
            14 => $userPhotos['photo1'] ?? '', // Required Photo 1
            15 => $userPhotos['photo2'] ?? '', // Required Photo 2
            16 => $userPhotos['photo3'] ?? '', // Additional Photo 1
            17 => $userPhotos['photo4'] ?? '', // Additional Photo 2
            19 => $user->getOccupation(), // Occupation
            20 => $user->getSmokingStatus(), // Smoking Status
            21 => $user->getHobbies(), // Hobbies
            22 => $user->getAboutMe(), // About Me
            23 => '0' // Harmony Score
        ];


        if (!updateUserProfile($userId, $dataToUpdate, '../data/users.csv')) {
            throw new Exception('Error updating data in CSV file.');
        }
        header('Location: /src/pages/profileViewer.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: /src/pages/profileCompletion.php');
    exit;
}
