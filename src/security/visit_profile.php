<?php
// Including utility functions
require_once '../utils/utils.php';

// Starting session for user interaction tracking or other session-based functionality
session_start();

// Checking if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieving visitor ID and visited ID from the POST data
    $visitorId = $_POST['visitor_id'];
    $visitedId = $_POST['visited_id'];

    try {
        // Logging the profile visit and storing the result
        $visitLogged = logProfileVisit($visitorId, $visitedId);

        // Checking if the visit was logged successfully or already logged
        if ($visitLogged) {
            // If visit was logged successfully, echo success message
            echo "Profile visit logged successfully.";
        } else {
            // If visit was already logged, echo message indicating it
            echo "Profile visit already logged.";
        }
    } catch (Exception $e) {
        // Catching any exceptions that occur during the logging process and echoing the error message
        echo "Error: " . $e->getMessage();
    }
}
