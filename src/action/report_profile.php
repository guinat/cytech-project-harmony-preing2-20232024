<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

// Function to add a CSV header if the file does not exist
function addCsvHeaderIfNotExist($filePath, $header)
{
    if (!file_exists($filePath)) {
        $handle = fopen($filePath, 'w'); // Open the file in write mode
        fputcsv($handle, $header); // Write the header row
        fclose($handle); // Close the file
    }
}

// Path to the CSV file where reported profiles are stored
$reportedProfilesFile = '../data/reported_profiles.csv';
$header = ['reporter_id', 'reported_user_id', 'reported_at', 'reason']; // Define the CSV header

addCsvHeaderIfNotExist($reportedProfilesFile, $header); // Ensure the header is added if the file does not exist

// Check if the request method is POST and the required POST data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $reporterId = $_SESSION['user_id']; // Get the reporter's ID from the session
    $reportedUserId = $_POST['user_id']; // Get the reported user's ID from the POST request
    $reportedAt = date('Y-m-d H:i:s'); // Get the current timestamp
    $reason = isset($_POST['reason']) ? $_POST['reason'] : 'Not specified'; // Get the reason from the POST request or default to 'Not specified'

    // Open the file in append mode to add the new report
    $handle = fopen($reportedProfilesFile, 'a');
    fputcsv($handle, [$reporterId, $reportedUserId, $reportedAt, $reason]); // Write the report details to the file
    fclose($handle); // Close the file

    // Respond with a success message in JSON format
    echo json_encode(['status' => 'success', 'message' => 'Profile reported successfully']);
} else {
    // Respond with an error message in JSON format for invalid requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit(); // Terminate the script
