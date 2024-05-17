<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: ../pages/login.php');
    exit;
}

ini_set('display_errors', 1); // Enable error display
error_reporting(E_ALL); // Report all types of errors

include_once '../entity/user.php'; // Include the user entity file

// Function to delete a conversation and related messages
function deleteConversation($conversationId)
{
    $conversationsFile = '../data/conversations.csv'; // Path to the conversations CSV file
    $tempFile = '../data/temp_conversations.csv'; // Temporary file for rewriting
    $deletedConversationsFile = '../data/deleted_conversations.csv'; // Path to the deleted conversations CSV file
    $deletedMessagesFile = '../data/deleted_messages.csv'; // Path to the deleted messages CSV file
    $messagesFile = '../data/messages.csv'; // Path to the messages CSV file
    $userId = $_SESSION['user_id']; // Get the user ID from the session

    $conversationData = null; // Initialize variable to hold the conversation data
    $messages = []; // Initialize array to hold the messages

    // Read the conversations file and find the conversation to delete
    if (($input = fopen($conversationsFile, 'r')) !== FALSE) {
        $output = fopen($tempFile, 'w'); // Open the temporary file for writing
        while (($data = fgetcsv($input, 1000, ",")) !== FALSE) {
            if ($data[0] == $conversationId) {
                $conversationData = $data; // Save the conversation data
            } else {
                fputcsv($output, $data); // Write other conversations to the temporary file
            }
        }
        fclose($input); // Close the input file
        fclose($output); // Close the output file
        rename($tempFile, $conversationsFile); // Rename the temporary file to the original file
    }

    // If the conversation was found and deleted, log it in deleted_conversations.csv
    if ($conversationData !== null) {
        if (($handle = fopen($deletedConversationsFile, 'a')) !== FALSE) {
            fputcsv($handle, array_merge($conversationData, [date('Y-m-d H:i:s')])); // Add the deletion timestamp
            fclose($handle); // Close the file
        }

        // Delete messages related to the conversation
        if (($input = fopen($messagesFile, 'r')) !== FALSE) {
            $output = fopen($tempFile, 'w'); // Open the temporary file for writing
            while (($data = fgetcsv($input, 1000, ",")) !== FALSE) {
                if ($data[1] == $conversationId) {
                    $messages[] = $data; // Save the message data
                } else {
                    fputcsv($output, $data); // Write other messages to the temporary file
                }
            }
            fclose($input); // Close the input file
            fclose($output); // Close the output file
            rename($tempFile, $messagesFile); // Rename the temporary file to the original file
        }

        // Log the deleted messages in deleted_messages.csv
        if (!empty($messages)) {
            if (($handle = fopen($deletedMessagesFile, 'a')) !== FALSE) {
                foreach ($messages as $message) {
                    fputcsv($handle, array_merge($message, [date('Y-m-d H:i:s')])); // Add the deletion timestamp
                }
                fclose($handle); // Close the file
            }
        }
    }
}

// Function to delete likes between the user and the blocked user
function deleteLike($userId, $blockedUserId)
{
    $likesFile = '../data/profile_likes.csv'; // Path to the likes CSV file
    $tempFile = '../data/temp_profile_likes.csv'; // Temporary file for rewriting

    if (($input = fopen($likesFile, 'r')) !== FALSE) {
        $output = fopen($tempFile, 'w'); // Open the temporary file for writing
        while (($data = fgetcsv($input, 1000, ",")) !== FALSE) {
            // Skip likes between the user and the blocked user
            if (!($data[0] == $userId && $data[1] == $blockedUserId) && !($data[0] == $blockedUserId && $data[1] == $userId)) {
                fputcsv($output, $data); // Write other likes to the temporary file
            }
        }
        fclose($input); // Close the input file
        fclose($output); // Close the output file
        rename($tempFile, $likesFile); // Rename the temporary file to the original file
    }
}

// Function to delete visits between the user and the blocked user
function deleteVisit($userId, $blockedUserId)
{
    $visitsFile = '../data/profile_visits.csv'; // Path to the visits CSV file
    $tempFile = '../data/temp_profile_visits.csv'; // Temporary file for rewriting

    if (($input = fopen($visitsFile, 'r')) !== FALSE) {
        $output = fopen($tempFile, 'w'); // Open the temporary file for writing
        while (($data = fgetcsv($input, 1000, ",")) !== FALSE) {
            // Skip visits between the user and the blocked user
            if (!($data[0] == $userId && $data[1] == $blockedUserId) && !($data[0] == $blockedUserId && $data[1] == $userId)) {
                fputcsv($output, $data); // Write other visits to the temporary file
            }
        }
        fclose($input); // Close the input file
        fclose($output); // Close the output file
        rename($tempFile, $visitsFile); // Rename the temporary file to the original file
    }
}

// Function to add a blocked user
function addBlockedUser($userId, $blockedUserId, $reason)
{
    $blockedUsersFile = '../data/blocked_users.csv'; // Path to the blocked users CSV file

    if (($handle = fopen($blockedUsersFile, 'a')) !== FALSE) {
        fputcsv($handle, [$userId, $blockedUserId, $reason, date('Y-m-d H:i:s')]); // Write the block details to the file
        fclose($handle); // Close the file
    } else {
        error_log("Failed to open the file: $blockedUsersFile"); // Log an error if the file cannot be opened
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id']; // Get the user ID from the session
    $blockedUserId = $_POST['user_id']; // Get the blocked user ID from the POST request
    $conversationId = $_POST['conversation_id']; // Get the conversation ID from the POST request
    $reason = $_POST['reason']; // Get the reason for blocking from the POST request

    // Add blocked user to the blocked list
    addBlockedUser($userId, $blockedUserId, $reason);

    // Delete the conversation
    deleteConversation($conversationId);

    // Delete likes
    deleteLike($userId, $blockedUserId);

    // Delete visits
    deleteVisit($userId, $blockedUserId);

    echo json_encode(['status' => 'success']); // Return a success message in JSON format
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']); // Return an error message in JSON format for invalid requests
}
