<?php

// Including utility functions
require_once '../utils/utils.php';

// Starting session to maintain user data across multiple pages
session_start();

// Setting content type to JSON
header('Content-Type: application/json');

// Checking if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieving liker ID and liked ID from POST data
    $likerId = $_POST['liker_id'];
    $likedId = $_POST['liked_id'];

    try {
        // Logging profile like
        $likeLogged = logProfileLike($likerId, $likedId);

        // Returning success message if like is logged successfully
        if ($likeLogged) {
            echo json_encode(['status' => 'success', 'message' => 'Profile liked successfully.']);
        } else {
            // Returning error message if the profile is already liked
            echo json_encode(['status' => 'error', 'message' => 'You have already liked this profile.']);
        }
    } catch (Exception $e) {
        // Returning error message if an exception occurs during the process
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
