<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        echo 'User ID not found in session.';
        exit;
    }

    $firstName = sanitizeInput($_POST['first_name'] ?? '');
    $lastName = sanitizeInput($_POST['last_name'] ?? '');
    $gender = sanitizeInput($_POST['gender'] ?? '');
    $birthDay = sanitizeInput($_POST['birth_day'] ?? '');
    $birthMonth = sanitizeInput($_POST['birth_month'] ?? '');
    $birthYear = sanitizeInput($_POST['birth_year'] ?? '');
    $country = sanitizeInput($_POST['country'] ?? '');
    $city = sanitizeInput($_POST['city'] ?? '');
    $lookingFor = sanitizeInput($_POST['looking_for'] ?? '');
    $occupation = sanitizeInput($_POST['occupation'] ?? '');
    $smokingStatus = sanitizeInput($_POST['smoking'] ?? '');
    $profileHeadline = sanitizeInput($_POST['profile_headline'] ?? '');
    $favoriteQuote = sanitizeInput($_POST['favorite_quote'] ?? '');
    $bio = sanitizeInput($_POST['bio'] ?? '');
    $aboutMe = sanitizeInput($_POST['about_me'] ?? '');
    $idealMatchDescription = sanitizeInput($_POST['ideal_match_description'] ?? '');
    $hobbies = sanitizeInput($_POST['hobbies'] ?? '');
    $interests = sanitizeInput($_POST['interests'] ?? '');

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

    $errors = [];
    if (empty($firstName) || empty($lastName)) {
        $errors[] = 'First name and last name are required.';
    }

    if (!validateDate($birthDay, $birthMonth, $birthYear)) {
        $errors[] = 'Invalid date of birth.';
    }

    if (empty($errors)) {
        $csvFile = '../data/users.csv';
        $role = 'ROLE_USER';
        $hrmny = 0;

        $dataToUpdate = [
            3 => $role,
            4 => $firstName,
            5 => $lastName,
            6 => $gender,
            7 => $birthYear . '-' . $birthMonth . '-' . $birthDay,
            8 => $country,
            9 => $city,
            10 => $lookingFor,
            11 => implode(',', $selectedMusics),
            12 => $uploadedPhotos['photo1'] ?? '',
            13 => $uploadedPhotos['photo2'] ?? '',
            14 => $uploadedPhotos['photo3'] ?? '',
            15 => $uploadedPhotos['photo4'] ?? '',
            16 => $occupation,
            17 => $smokingStatus,
            18 => $hobbies,
            19 => $interests,
            20 => $profileHeadline,
            21 => $favoriteQuote,
            22 => $bio,
            23 => $aboutMe,
            24 => $idealMatchDescription,
            25 => $hrmny
        ];

        if (updateUserProfile($userId, $dataToUpdate, $csvFile)) {
            header('Location: ../pages/welcome.php');
            exit();
        } else {
            echo 'Error updating data in CSV file.';
        }
    } else {
        echo 'Errors encountered during form submission:';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}
