<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
    exit;
}

$likerId = $_POST['liker_id'] ?? null;
$likedId = $_POST['liked_id'] ?? null;

if ($likerId && $likedId) {
    $likesFile = '../data/profile_likes.csv';
    $matchesFile = '../data/matches.csv';

    removeLike($likerId, $likedId, $likesFile);
    removeMatch($likerId, $likedId, $matchesFile);

    echo json_encode(['status' => 'success', 'message' => 'Unliked successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit();

function removeLike($userId, $likedUserId, $likesFile)
{
    $tempFile = tempnam(sys_get_temp_dir(), 'likes');
    $handle = fopen($likesFile, 'r');
    $tempHandle = fopen($tempFile, 'w');

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($data[0] != $userId || $data[1] != $likedUserId) {
            fputcsv($tempHandle, $data);
        }
    }

    fclose($handle);
    fclose($tempHandle);
    unlink($likesFile);
    rename($tempFile, $likesFile);
}

function removeMatch($userId1, $userId2, $matchesFile)
{
    $tempFile = tempnam(sys_get_temp_dir(), 'matches');
    $handle = fopen($matchesFile, 'r');
    $tempHandle = fopen($tempFile, 'w');

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (!(($data[0] == $userId1 && $data[1] == $userId2) || ($data[0] == $userId2 && $data[1] == $userId1))) {
            fputcsv($tempHandle, $data);
        }
    }

    fclose($handle);
    fclose($tempHandle);
    unlink($matchesFile);
    rename($tempFile, $matchesFile);
}
