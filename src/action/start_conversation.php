<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

include_once '../entity/user.php'; // Include the user entity file

$userId = $_SESSION['user_id']; // Get the current user's ID from the session
$otherUserId = $_POST['user_id']; // Get the ID of the other user from the POST request
$createdAt = date('Y-m-d H:i:s'); // Get the current timestamp

// Path to the CSV file where conversations are stored
$conversationsFile = '../data/conversations.csv';

// Check if the conversations file does not exist
if (!file_exists($conversationsFile)) {
    // Create the file and add the header row
    $file = fopen($conversationsFile, 'w');
    fputcsv($file, ['conversation_id', 'user1_id', 'user2_id', 'created_at']);
    fclose($file); // Close the file after writing the header
}

// Generate a unique ID for the new conversation
$conversationId = uniqid();

// Open the file in append mode to add the new conversation
$file = fopen($conversationsFile, 'a');
fputcsv($file, [$conversationId, $userId, $otherUserId, $createdAt]); // Write the conversation details to the file
fclose($file); // Close the file

header('Content-Type: application/json'); // Set the response content type to JSON
echo json_encode(['conversation_id' => $conversationId]); // Return the new conversation ID in JSON format
exit(); // Terminate the script
