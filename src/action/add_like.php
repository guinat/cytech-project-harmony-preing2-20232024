<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit;
}

function addCsvHeaderIfNotExist($filePath, $header)
{
    if (!file_exists($filePath)) {
        $handle = fopen($filePath, 'w');
        fputcsv($handle, $header);
        fclose($handle);
    }
}

$likesFile = '../data/profile_likes.csv';
$matchesFile = '../data/matches.csv';
$likesHeader = ['user_id', 'liked_user_id', 'liked_at'];
$matchesHeader = ['user_id1', 'user_id2', 'matched_at'];

addCsvHeaderIfNotExist($likesFile, $likesHeader);
addCsvHeaderIfNotExist($matchesFile, $matchesHeader);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['liked_user_id'])) {
    $userId = $_SESSION['user_id'];
    $likedUserId = $_POST['liked_user_id'];
    $likedAt = date('Y-m-d H:i:s');

    // Ajouter le like
    $handle = fopen($likesFile, 'a');
    fputcsv($handle, [$userId, $likedUserId, $likedAt]);
    fclose($handle);

    // Vérifier s'il y a un match réciproque
    if (isMutualLike($userId, $likedUserId, $likesFile)) {
        $handle = fopen($matchesFile, 'a');
        fputcsv($handle, [$userId, $likedUserId, $likedAt]);
        fclose($handle);

        echo json_encode(['status' => 'success', 'message' => 'Matched successfully']);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Liked successfully']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit();

function isMutualLike($userId, $likedUserId, $likesFile)
{
    if (($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $likedUserId && $data[1] == $userId) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}
