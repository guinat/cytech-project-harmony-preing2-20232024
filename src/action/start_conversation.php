<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit;
}

$conversationsFile = '../data/conversations.csv';
$currentUserId = $_SESSION['user_id'];
$otherUserId = $_POST['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $otherUserId) {
    // Check if a conversation already exists between the two users
    if (($handle = fopen($conversationsFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (
                ($data[1] == $currentUserId && $data[2] == $otherUserId) ||
                ($data[1] == $otherUserId && $data[2] == $currentUserId)
            ) {
                // Conversation already exists
                fclose($handle);
                echo json_encode(['conversation_id' => $data[0]]);
                exit;
            }
        }
        fclose($handle);
    }

    // If no existing conversation, create a new one
    $conversationId = uniqid();
    $createdAt = date('Y-m-d H:i:s');

    if (($handle = fopen($conversationsFile, 'a')) !== FALSE) {
        fputcsv($handle, [$conversationId, $currentUserId, $otherUserId, $createdAt]);
        fclose($handle);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to open conversations file']);
        exit;
    }

    echo json_encode(['conversation_id' => $conversationId]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit();
