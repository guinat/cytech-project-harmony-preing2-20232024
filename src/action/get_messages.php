<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

$conversationId = $_GET['conversation_id']; // Get the conversation ID from the GET request
$messagesFile = '../data/messages.csv'; // Path to the CSV file where messages are stored
$messages = []; // Initialize an array to hold the messages

// Open the CSV file in read mode
if (($handle = fopen($messagesFile, 'r')) !== FALSE) {
    fgetcsv($handle); // Skip the header row
    // Loop through each row in the CSV file
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Check if the conversation ID matches
        if ($data[1] == $conversationId) {
            // Add the message to the messages array
            $messages[] = [
                'message_id' => $data[0],
                'conversation_id' => $data[1],
                'sender_id' => $data[2],
                'message_text' => $data[3],
                'timestamp' => $data[4],
            ];
        }
    }
    fclose($handle); // Close the file
}

header('Content-Type: application/json'); // Set the response content type to JSON
echo json_encode($messages); // Return the messages in JSON format
exit(); // Terminate the script
