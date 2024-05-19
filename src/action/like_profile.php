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
    $likedAt = date('Y-m-d H:i:s');

    if (!isLikeExist($likerId, $likedId, $likesFile)) {
        // Ajouter le like
        $handle = fopen($likesFile, 'a');
        fputcsv($handle, [$likerId, $likedId, $likedAt]);
        fclose($handle);

        // Vérifier s'il y a un match réciproque
        if (isMutualLike($likerId, $likedId, $likesFile) && !isMatchExist($likerId, $likedId, $matchesFile)) {
            $handle = fopen($matchesFile, 'a');
            fputcsv($handle, [$likerId, $likedId, $likedAt]);
            fclose($handle);

            echo json_encode(['status' => 'success', 'message' => 'Matched successfully']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Liked successfully']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Like already exists']);
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

function isLikeExist($userId, $likedUserId, $likesFile)
{
    if (($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId && $data[1] == $likedUserId) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

function isMatchExist($userId1, $userId2, $matchesFile)
{
    if (($handle = fopen($matchesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (($data[0] == $userId1 && $data[1] == $userId2) || ($data[0] == $userId2 && $data[1] == $userId1)) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}
