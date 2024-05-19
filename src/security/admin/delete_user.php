<?php
// Start the session to manage user session data
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ROLE_ADMIN') {
    // If not, redirect to the login page
    header('Location: ../logout.php');
    exit;
}

// Function to delete a user from the users CSV file
function deleteUser($userId, $csvFilePath)
{
    if (file_exists($csvFilePath)) {
        $users = [];
        $deletedUser = null;
        // Open the CSV file for reading
        $handle = fopen($csvFilePath, 'r');
        // Read through the file and collect all users except the one to be deleted
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] != $userId) {
                $users[] = $data;
            } else {
                $deletedUser = $data;
            }
        }
        fclose($handle);

        // Open the CSV file for writing and save the remaining users
        $handle = fopen($csvFilePath, 'w');
        foreach ($users as $user) {
            fputcsv($handle, $user);
        }
        fclose($handle);

        // Save the deleted user data to a separate file
        if ($deletedUser !== null) {
            saveDeletedUser($deletedUser, '../../data/deleted_users.csv');
        }
    }
}

// Function to delete conversations and related messages of a user
function deleteConversations($userId, $conversationsFilePath, $messagesFilePath, $deletedConversationsFilePath)
{
    $conversations = [];
    $deletedConversations = [];
    // Load existing conversations and filter out the ones associated with the user to delete
    if (file_exists($conversationsFilePath) && ($handle = fopen($conversationsFilePath, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[1] == $userId || $data[2] == $userId) {
                // Log the deleted conversation
                $deletedConversations[] = [$data[0], $userId, 'User deleted', date('Y-m-d H:i:s')];
            } else {
                $conversations[] = $data;
            }
        }
        fclose($handle);
    }

    // Save updated conversations list
    if (($handle = fopen($conversationsFilePath, 'w')) !== FALSE) {
        foreach ($conversations as $conversation) {
            fputcsv($handle, $conversation);
        }
        fclose($handle);
    }

    // Save deleted conversations log
    if (($handle = fopen($deletedConversationsFilePath, 'a')) !== FALSE) {
        foreach ($deletedConversations as $deletedConversation) {
            fputcsv($handle, $deletedConversation);
        }
        fclose($handle);
    }

    $messages = [];
    // Load existing messages and filter out the ones associated with the deleted conversations
    if (file_exists($messagesFilePath) && ($handle = fopen($messagesFilePath, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $conversationId = $data[1];
            $isDeletedConversation = false;
            foreach ($deletedConversations as $deletedConversation) {
                if ($deletedConversation[0] == $conversationId) {
                    $isDeletedConversation = true;
                    break;
                }
            }
            if (!$isDeletedConversation) {
                $messages[] = $data;
            }
        }
        fclose($handle);
    }

    // Save updated messages list
    if (($handle = fopen($messagesFilePath, 'w')) !== FALSE) {
        foreach ($messages as $message) {
            fputcsv($handle, $message);
        }
        fclose($handle);
    }
}

// Function to add an email to the blacklist CSV file
function blacklistEmail($email, $blacklistFilePath)
{
    // Check if the blacklist file exists, and open it for appending
    if (file_exists($blacklistFilePath)) {
        $handle = fopen($blacklistFilePath, 'a');
        fputcsv($handle, [$email]);
        fclose($handle);
    } else {
        // If the file doesn't exist, create it and write the email
        $handle = fopen($blacklistFilePath, 'w');
        fputcsv($handle, ['email']);
        fputcsv($handle, [$email]);
        fclose($handle);
    }
}

// Function to save deleted user data to a separate CSV file
function saveDeletedUser($userData, $deletedUsersFilePath)
{
    // Check if the file can be opened for appending
    if (($handle = fopen($deletedUsersFilePath, 'a')) !== FALSE) {
        fputcsv($handle, $userData);
        fclose($handle);
    } else {
        // If the file doesn't exist, create it and write the user data
        $handle = fopen($deletedUsersFilePath, 'w');
        fputcsv($handle, ['id', 'email', 'password', 'username', 'role', 'first_name', 'last_name', 'gender', 'date_of_birth', 'country', 'city', 'looking_for', 'music_preferences', 'photo_1', 'photo_2', 'photo_3', 'photo_4', 'occupation', 'smoking_status', 'hobbies', 'about_me', 'subscription', 'subscription_start_date', 'subscription_end_date']);
        fputcsv($handle, $userData);
        fclose($handle);
    }
}

// Check if a user ID is provided in the query parameters
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    // Delete the user and their associated data
    deleteUser($userId, '../../data/users.csv');
    deleteConversations($userId, '../../data/conversations.csv', '../../data/messages.csv', '../../data/deleted_conversations.csv');

    // Check if an email is provided for blacklisting
    if (isset($_GET['blacklist'])) {
        $emailToBlacklist = $_GET['blacklist'];
        blacklistEmail($emailToBlacklist, '../../data/blacklist.csv');
    }

    // Redirect to the admin dashboard
    header('Location: admin_dashboard.php');
    exit;
} else {
    // If no user ID is provided, display an error message
    echo "Invalid user ID.";
    exit;
}
