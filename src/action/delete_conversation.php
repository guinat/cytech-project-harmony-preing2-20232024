<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

$conversationId = $_POST['conversation_id']; // Get the conversation ID from the POST request
$reason = $_POST['reason']; // Get the reason for deletion from the POST request
$userId = $_SESSION['user_id']; // Get the user ID from the session
$deletedConversationsFile = '../data/deleted_conversations.csv'; // Path to the CSV file where deleted conversations are logged
$messagesFile = '../data/messages.csv'; // Path to the CSV file where messages are stored

// Log the deleted conversation
if (($handle = fopen($deletedConversationsFile, 'a')) !== FALSE) {
    fputcsv($handle, [$conversationId, $userId, $reason, date('Y-m-d H:i:s')]); // Write the deletion details to the file
    fclose($handle); // Close the file
}

// Load existing messages
$messages = [];
if (($handle = fopen($messagesFile, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($data[1] != $conversationId) { // Only keep messages that are not part of the deleted conversation
            $messages[] = $data;
        }
    }
    fclose($handle); // Close the file
}

// Save updated messages
if (($handle = fopen($messagesFile, 'w')) !== FALSE) {
    foreach ($messages as $message) {
        fputcsv($handle, $message); // Write each message back to the file
    }
    fclose($handle); // Close the file
}

echo json_encode(['status' => 'success']); // Return a success message in JSON format
exit(); // Terminate the script
