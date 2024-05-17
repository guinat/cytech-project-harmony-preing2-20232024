<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

$senderId = $_SESSION['user_id']; // Get the ID of the current user (the sender) from the session
$conversationId = $_POST['conversation_id']; // Get the conversation ID from the POST request
$messageText = $_POST['message']; // Get the message text from the POST request
$timestamp = date('Y-m-d H:i:s'); // Get the current timestamp

// Path to the CSV file where messages are stored
$messagesFile = '../data/messages.csv';

// Check if the messages file does not exist
if (!file_exists($messagesFile)) {
    // Create the file and add the header row
    $file = fopen($messagesFile, 'w');
    fputcsv($file, ['message_id', 'conversation_id', 'sender_id', 'message_text', 'timestamp']);
    fclose($file); // Close the file after writing the header
}

// Generate a unique ID for the new message
$messageId = uniqid();

// Open the file in append mode to add the new message
$file = fopen($messagesFile, 'a');
fputcsv($file, [$messageId, $conversationId, $senderId, $messageText, $timestamp]); // Write the message details to the file
fclose($file); // Close the file

header('Content-Type: application/json'); // Set the response content type to JSON
echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']); // Return a success message in JSON format
exit(); // Terminate the script
