<?php
require_once '../entity/users.php';
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
        $user->setInterests(sanitizeInput($_POST['interests'] ?? ''));
        $user->setProfileHeadline(sanitizeInput($_POST['profile_headline'] ?? ''));
        $user->setFavoriteQuote(sanitizeInput($_POST['favorite_quote'] ?? ''));
        $user->setBio(sanitizeInput($_POST['bio'] ?? ''));
        $user->setAboutMe(sanitizeInput($_POST['about_me'] ?? ''));
        $user->setIdealMatchDescription(sanitizeInput($_POST['ideal_match_description'] ?? ''));
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
            3 => 'ROLE_USER',  // Role
            4 => $user->getFirstName(), // First Name
            5 => $user->getLastName(), // Last Name
            6 => $user->getGender(), // Gender
            7 => $user->getDateOfBirth(), // Date of Birth
            8 => $user->getCountry(), // Country
            9 => $user->getCity(), // City
            10 => $user->getLookingFor(), // Looking For
            11 => $user->getMusicPreferences(), // Music Preferences
            12 => $userPhotos['photo1'] ?? '', // Required Photo 1
            13 => $userPhotos['photo2'] ?? '', // Required Photo 2
            14 => $userPhotos['photo3'] ?? '', // Additional Photo 1
            15 => $userPhotos['photo4'] ?? '', // Additional Photo 2
            16 => $user->getOccupation(), // Occupation
            17 => $user->getSmokingStatus(), // Smoking Status
            18 => $user->getHobbies(), // Hobbies
            19 => $user->getInterests(), // Interests
            20 => $user->getProfileHeadline(), // Profile Headline
            21 => $user->getFavoriteQuote(), // Favorite Quote
            22 => $user->getBio(), // Bio
            23 => $user->getAboutMe(), // About Me
            24 => $user->getIdealMatchDescription(), // Ideal Match Description
            25 => '0' // Harmony Score
        ];


        if (!updateUserProfile($userId, $dataToUpdate, '../data/users.csv')) {
            throw new Exception('Error updating data in CSV file.');
        }
        header('Location: ../pages/welcome.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: ../pages/profile.php');
    exit;
}
