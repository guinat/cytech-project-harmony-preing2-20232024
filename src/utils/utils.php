<?php

// Function to sanitize input data
function sanitizeInput($data)
{
    // Remove leading/trailing whitespaces, escape HTML characters, and remove backslashes
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to check and update user subscription status
function checkSubscription($user)
{
    // Get subscription end date from user object
    $subscriptionEndDate = $user->getSubscriptionEndDate();

    // Check if subscription end date is set and if it's in the past
    if ($subscriptionEndDate && strtotime($subscriptionEndDate) < time()) {
        // If subscription has expired, reset subscription details
        $user->setSubscription('');
        $user->setSubscriptionEndDate(null);

        // Prepare data to update user profile
        $dataToUpdate = [
            23 => '', // Subscription
            24 => '', // Subscription Start Date
            25 => ''  // Subscription End Date
        ];

        // Update user profile with new subscription details
        updateUserProfile($user->getId(), $dataToUpdate, '../data/users.csv');
    }
}

// Function to log profile visits
function logProfileVisit($visitorId, $visitedId, $filePath = '../data/profile_visits.csv')
{
    // Prepare visit data
    $visitData = [$visitorId, $visitedId, date('Y-m-d H:i:s')];
    $fileExists = file_exists($filePath);

    // Check if the visit already exists in the CSV file
    if ($fileExists && ($handle = fopen($filePath, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $visitorId && $data[1] == $visitedId) {
                fclose($handle);
                return false; // Visit already exists
            }
        }
        fclose($handle);
    }

    // Append the new visit to the CSV file
    if (($handle = fopen($filePath, 'a')) !== FALSE) {
        if (!$fileExists) {
            // Write the header if the file does not exist
            fputcsv($handle, ['visitor_id', 'visited_id', 'timestamp']);
        }
        fputcsv($handle, $visitData);
        fclose($handle);
        return true;
    } else {
        throw new Exception('Could not open the file for writing.');
    }
}

// Function to log profile likes
function logProfileLike($likerId, $likedId, $filePath = '../data/profile_likes.csv')
{
    // Prepare like data
    $likeData = [$likerId, $likedId, date('Y-m-d H:i:s')];
    $fileExists = file_exists($filePath);

    // Check if the like already exists in the CSV file
    if ($fileExists && ($handle = fopen($filePath, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $likerId && $data[1] == $likedId) {
                fclose($handle);
                return false; // Like already exists
            }
        }
        fclose($handle);
    }

    // Append the new like to the CSV file
    if (($handle = fopen($filePath, 'a')) !== FALSE) {
        if (!$fileExists) {
            // Write the header if the file does not exist
            fputcsv($handle, ['liker_id', 'liked_id', 'timestamp']);
        }
        fputcsv($handle, $likeData);
        fclose($handle);
        return true;
    } else {
        throw new Exception('Could not open the file for writing.');
    }
}
