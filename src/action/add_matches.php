<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit;
}

function addCsvHeaderIfNotExist($filePath, $header)
{
    if (!file_exists($filePath)) {
        $handle = fopen($filePath, 'w');
        if ($handle === false) {
            error_log('Failed to open file for writing: ' . $filePath);
            return false;
        }
        fputcsv($handle, $header);
        fclose($handle);
    }
}

$matchesFile = '../data/matches.csv';
$header = ['user_id1', 'user_id2', 'matched_at'];

if (!addCsvHeaderIfNotExist($matchesFile, $header)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create CSV header']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId1 = $_SESSION['user_id'];
    $userId2 = $_POST['user_id'];
    $matchedAt = date('Y-m-d H:i:s');

    $handle = fopen($matchesFile, 'a');
    if ($handle === false) {
        error_log('Failed to open file for appending: ' . $matchesFile);
        echo json_encode(['status' => 'error', 'message' => 'Failed to write to CSV']);
        exit;
    }
    if (fputcsv($handle, [$userId1, $userId2, $matchedAt]) === false) {
        error_log('Failed to write data to CSV: ' . $matchesFile);
        echo json_encode(['status' => 'error', 'message' => 'Failed to write data to CSV']);
        fclose($handle);
        exit;
    }
    fclose($handle);

    echo json_encode(['status' => 'success', 'message' => 'Match added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
exit();
