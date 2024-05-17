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

// Function to get a message by its ID
function getMessageById($messageId, $messagesFile)
{
    if (($handle = fopen($messagesFile, 'r')) !== FALSE) { // Open the file in read mode
        fgetcsv($handle); // Skip the header row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Loop through each row
            if ($data[0] == $messageId) { // Check if the message ID matches
                fclose($handle); // Close the file
                return $data; // Return the message data
            }
        }
        fclose($handle); // Close the file if no match found
    }
    return null; // Return null if the message is not found
}

$messagesFile = '../data/messages.csv'; // Path to the CSV file where messages are stored
$deletedMessagesFile = '../data/deleted_messages.csv'; // Path to the CSV file where deleted messages are stored
$header = ['message_id', 'conversation_id', 'sender_id', 'message_text', 'timestamp', 'deleted_at']; // Define the CSV header for deleted messages

// Add header to deleted messages file if it does not exist
addCsvHeaderIfNotExist($deletedMessagesFile, $header);

// Check if the request method is POST and the required POST data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
    $messageId = $_POST['message_id']; // Get the message ID from the POST request
    $message = getMessageById($messageId, $messagesFile); // Get the message by ID

    if ($message) {
        // Add delete timestamp to the message data
        $message[] = date('Y-m-d H:i:s');

        // Append the deleted message to the deleted_messages.csv file
        $handle = fopen($deletedMessagesFile, 'a');
        fputcsv($handle, $message);
        fclose($handle);

        // Remove the message from the messages.csv file
        $allMessages = [];
        if (($handle = fopen($messagesFile, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Read the header
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($data[0] != $messageId) { // Skip the deleted message
                    $allMessages[] = $data;
                }
            }
            fclose($handle);
        }

        // Rewrite the messages.csv file without the deleted message
        $handle = fopen($messagesFile, 'w');
        fputcsv($handle, $header); // Rewrite the header
        foreach ($allMessages as $message) {
            fputcsv($handle, $message);
        }
        fclose($handle);

        // Respond with a success message in JSON format
        echo json_encode(['status' => 'success', 'message' => 'Message deleted']);
    } else {
        // Respond with an error message in JSON format if the message is not found
        echo json_encode(['status' => 'error', 'message' => 'Message not found']);
    }
} else {
    // Respond with an error message in JSON format for invalid requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit(); // Terminate the script
