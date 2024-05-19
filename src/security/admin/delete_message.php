<?php
// Start the session to manage user session data
session_start();

// Check if the user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ROLE_ADMIN') {
    // If not, redirect to the login page
    header('Location: ../logout.php');
    exit;
}

// Function to delete a message by message ID
function deleteMessage($messageId)
{
    // Paths to the main messages CSV file and a temporary file for updates
    $filePath = '../../data/messages.csv';
    $tempFilePath = '../../data/messages_temp.csv';
    $deleted = false;

    // Check if the files can be opened for reading and writing
    if (($handle = fopen($filePath, 'r')) !== FALSE && ($tempHandle = fopen($tempFilePath, 'w')) !== FALSE) {
        // Copy the header row
        $header = fgetcsv($handle);
        fputcsv($tempHandle, $header);

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // If the current row does not correspond to the specified message ID, write it to the temporary file
            if ($data[0] != $messageId) {
                fputcsv($tempHandle, $data);
            } else {
                // Mark as deleted if the message ID matches
                $deleted = true;
            }
        }

        // Close both the original and temporary files
        fclose($handle);
        fclose($tempHandle);

        // Replace the original file with the updated temporary file if a message was deleted
        if ($deleted) {
            rename($tempFilePath, $filePath);
        } else {
            // Otherwise, delete the temporary file
            unlink($tempFilePath);
        }

        return $deleted;
    }

    return false;
}

// Get the current message ID from the query parameters
$currentMessageId = $_GET['id'];

// Attempt to delete the message
if (deleteMessage($currentMessageId)) {
    echo "Message deleted successfully.";
} else {
    echo "Failed to delete message.";
}

// Redirect to the conversation details page
header('Location: conversation_details.php?id=' . $_GET['conversation_id']);
exit;
