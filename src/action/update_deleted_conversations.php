<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect to the login page if the request method is not POST
    header('Location: ../pages/login.php');
    exit;
}

// Get the conversation ID and reason from the POST request
$conversationId = $_POST['conversation_id'];
$reason = $_POST['reason'];
$userId = $_SESSION['user_id'];
$timestamp = date('Y-m-d H:i:s'); // Get the current timestamp

// Path to the CSV file where deleted conversations are logged
$deletedConversationsFile = '../data/deleted_conversations.csv';

// Check if the file already exists
$fileExists = file_exists($deletedConversationsFile);

// Open the file in append mode
if (($handle = fopen($deletedConversationsFile, 'a')) !== FALSE) {
    // If the file is new (i.e., it does not exist), add the header row
    if (!$fileExists) {
        fputcsv($handle, ['conversation_id', 'user_id', 'reason', 'timestamp']);
    }
    // Add the conversation deletion data to the CSV file
    fputcsv($handle, [$conversationId, $userId, $reason, $timestamp]);
    fclose($handle); // Close the file
    // Respond with a success message in JSON format
    echo json_encode(['status' => 'success']);
} else {
    // Respond with an error message in JSON format if the file could not be opened
    echo json_encode(['status' => 'error', 'message' => 'Failed to open the file.']);
}
exit(); // Terminate the script
