<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit;
}

function checkMatch($userId, $likedUserId)
{
    $matchesFile = '../data/matches.csv';
    if (($handle = fopen($matchesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (($data[0] == $userId && $data[1] == $likedUserId) || ($data[0] == $likedUserId && $data[1] == $userId)) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['liked_user_id'])) {
    $userId = $_SESSION['user_id'];
    $likedUserId = $_POST['liked_user_id'];

    if (checkMatch($userId, $likedUserId)) {
        echo json_encode(['status' => 'success', 'message' => 'Match found']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No match found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit();
