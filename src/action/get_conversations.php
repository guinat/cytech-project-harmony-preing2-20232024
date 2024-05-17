<?php
session_start(); // Start the session

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

ini_set('display_errors', 1); // Enable error display
error_reporting(E_ALL); // Report all types of errors

include_once '../entity/user.php'; // Include the User entity class

// Function to get the list of deleted conversations
function getDeletedConversations()
{
    $deletedConversations = [];
    $deletedConversationsFile = '../data/deleted_conversations.csv';
    if (file_exists($deletedConversationsFile) && ($handle = fopen($deletedConversationsFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $deletedConversations[] = $data[0];
        }
        fclose($handle);
    }
    return $deletedConversations;
}

// Function to get the list of conversations for the current user
function getConversations($userId)
{
    $conversations = [];
    $deletedConversations = getDeletedConversations();
    $conversationsFile = '../data/conversations.csv';
    if (file_exists($conversationsFile) && ($handle = fopen($conversationsFile, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip header row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (($data[1] == $userId || $data[2] == $userId) && !in_array($data[0], $deletedConversations)) {
                $conversations[] = $data;
            }
        }
        fclose($handle);
    }

    // Sort conversations by creation date in descending order
    usort($conversations, function ($a, $b) {
        return strtotime($b[3]) - strtotime($a[3]);
    });

    return $conversations;
}


$currentUserId = $_SESSION['user_id'];
$conversations = getConversations($currentUserId);

$response = [];
foreach ($conversations as $conversation) {
    $conversationId = $conversation[0];
    $userId = ($conversation[1] == $currentUserId) ? $conversation[2] : $conversation[1];
    $user = getUserById($userId, '../data/users.csv');
    if ($user) {
        $response[] = [
            'id' => $conversationId,
            'userId' => $user->getId(),
            'userName' => $user->getFirstName() . ' ' . $user->getLastName(),
            'lastMessageDate' => $conversation[3] // Assuming column 3 is the creation date
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
