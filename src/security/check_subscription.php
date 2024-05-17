<?php

// Including user entity and utility functions
require_once '../entity/user.php';
require_once '../utils/utils.php';

// Displaying errors for debugging purposes
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Starting session to maintain user data across multiple pages
session_start();

// Checking if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieving user ID and CSV file path from POST data
    $userId = $_POST['user_id'];
    $csvFile = '../data/users.csv';

    // Getting user object from the CSV file
    $user = getUser($userId, $csvFile);

    if ($user) {
        // Retrieving subscription end date from the user object
        $subscriptionEndDate = $user->getSubscriptionEndDate();
        // Getting the current date and time
        $currentDate = date('Y-m-d H:i:s');

        // Checking if subscription end date is not empty
        if (!empty($subscriptionEndDate)) {
            // Converting subscription end date and current date to timestamps for comparison
            $subscriptionEndTimestamp = strtotime($subscriptionEndDate);
            $currentTimestamp = strtotime($currentDate);

            // Adding logs to check the values
            error_log("Subscription End Date: " . $subscriptionEndDate);
            error_log("Current Date: " . $currentDate);
            error_log("Subscription End Timestamp: " . $subscriptionEndTimestamp);
            error_log("Current Timestamp: " . $currentTimestamp);

            // Checking if the subscription has expired
            if ($subscriptionEndTimestamp < $currentTimestamp) {
                // Updating user subscription details
                $user->setSubscription('');
                $user->setSubscriptionStartDate(null);
                $user->setSubscriptionEndDate(null);

                // Data to update in the CSV file
                $dataToUpdate = [
                    22 => '', // Subscription
                    23 => '', // Subscription Start Date
                    24 => ''  // Subscription End Date
                ];

                // Updating user profile in the CSV file
                $dataUpdated = updateUserProfile($userId, $dataToUpdate, $csvFile);

                // Checking if the data is updated successfully
                if ($dataUpdated) {
                    // Updating user session with subscription details
                    $_SESSION['subscription'] = $user->getSubscription();
                    $_SESSION['subscription_start_date'] = $user->getSubscriptionStartDate();
                    $_SESSION['subscription_end_date'] = $user->getSubscriptionEndDate();
                    echo "Subscription updated successfully.";
                } else {
                    echo "Error updating subscription.";
                }
            } else {
                echo "Subscription still valid.";
            }
        } else {
            echo "No subscription end date.";
        }
    } else {
        echo "User not found.";
    }
}
