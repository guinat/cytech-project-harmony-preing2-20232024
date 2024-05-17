<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../entity/user.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$currentUserId = $_SESSION['user_id'];

// Function to get mutual likes
function getMutualLikes($userId)
{
    $likesFile = '../data/profile_likes.csv';
    $likes = [];
    $likedBy = [];
    $mutualLikes = [];

    if (!file_exists($likesFile)) {
        return [];
    }

    if (($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $likes[] = $data[1];
            } elseif ($data[1] == $userId) {
                $likedBy[] = $data[0];
            }
        }
        fclose($handle);
    }

    foreach ($likes as $like) {
        if (in_array($like, $likedBy)) {
            $mutualLikes[] = $like;
        }
    }

    return $mutualLikes;
}

$matchedUserIds = getMutualLikes($currentUserId);
$matchedUsers = [];

foreach ($matchedUserIds as $userId) {
    $user = getUser($userId, '../data/users.csv'); // Use the method from the UserEntity class
    if ($user !== null) {
        $matchedUsers[] = $user;
    }
}

// Clean the output buffer before sending JSON response
ob_clean();

header('Content-Type: application/json');
echo json_encode(array_map(function ($user) {
    return [
        'id' => $user->getId(),
        'first_name' => $user->getFirstName(),
        'photos' => $user->getPhotos()
    ];
}, $matchedUsers));
