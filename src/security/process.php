<?php

// Including user entity and utility functions
require_once '../entity/user.php';
require_once '../utils/utils.php';

// Starting session to maintain user data across multiple pages
session_start();

// Checking if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieving user ID from session
    $userId = $_SESSION['user_id'];
    // CSV file path
    $csvFile = '../data/users.csv';
    // Retrieving user details from CSV file
    $user = getUserById($userId, $csvFile);

    if ($user) {
        // Retrieving card details from POST data
        $cardNumber = $_POST['card-number'];
        $expiryDate = $_POST['expiry-date'];
        $cvv = $_POST['cvv'];
        $subscription = $_POST['subscription'] ?? '';
        // Storing subscription in session
        $_SESSION['subscription'] = $subscription;

        // Validating card details
        if ($cardNumber === '4111111111111111' && $expiryDate === '12/24' && $cvv === '123') {
            // Setting subscription start date and end date based on subscription duration
            $startDate = date('Y-m-d H:i:s');
            $endDate = null;
            if ($subscription === '1week') {
                $endDate = date('Y-m-d H:i:s', strtotime('+1 week'));
            } elseif ($subscription === '1month') {
                $endDate = date('Y-m-d H:i:s', strtotime('+1 month'));
            } elseif ($subscription === '6months') {
                $endDate = date('Y-m-d H:i:s', strtotime('+6 months'));
            }

            // Updating user profile with subscription details
            $user->setUpdatedAt($startDate);
            $user->setSubscription($subscription);
            $user->setSubscriptionStartDate($startDate);
            $user->setSubscriptionEndDate($endDate);

            // Storing subscription start and end date in session
            $_SESSION['subscription_start_date'] = $startDate;
            $_SESSION['subscription_end_date'] = $endDate;

            // Data to update in the CSV file
            $dataToUpdate = [
                2 => $user->getUpdatedAt(),
                22 => $user->getSubscription(),
                23 => $user->getSubscriptionStartDate(),
                24 => $user->getSubscriptionEndDate()
            ];

            // Debug log
            error_log("Updating user profile with: " . print_r($dataToUpdate, true));

            // Updating user profile in the CSV file
            $dataUpdated = updateUserProfile($userId, $dataToUpdate, $csvFile);

            // Redirecting to confirmation page if data is updated successfully
            if ($dataUpdated) {
                header('Location: ../pages/confirmation.php');
                exit();
            } else {
                echo "Error updating subscription.";
            }
        } else {
            echo "Credit card information is not valid.";
        }
    } else {
        echo "User not found.";
    }
}
