<?php
// Start the session to manage user session data
session_start();

// Include the file that contains the UserEntity class definition
include_once '../entity/user.php';

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header('Location: ../pages/login.php');
    exit;
}

// Function to update the user's role in the CSV file
function updateUserRole($userId, $newRole)
{
    // Path to the main users CSV file and a temporary file for updates
    $filePath = '../data/users.csv';
    $tempFilePath = '../data/users_temp.csv';
    $updated = false;

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        // Open the temporary file for writing
        $tempHandle = fopen($tempFilePath, 'w');
        // Write the header row to the temporary file
        fputcsv($tempHandle, fgetcsv($handle));

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // If the current row corresponds to the user to be updated
            if ($data[0] == $userId) {
                // Update the role and other relevant fields
                $data[6] = $newRole;
                $data[23] = 'admin';
                $data[24] = date('Y-m-d');
                $data[25] = date('Y-m-d', strtotime('+100 year'));

                // Mark as updated
                $updated = true;
            }
            // Write the (potentially updated) row to the temporary file
            fputcsv($tempHandle, $data);
        }
        // Close both the original and temporary files
        fclose($handle);
        fclose($tempHandle);

        // Replace the original file with the updated temporary file
        rename($tempFilePath, $filePath);
    }

    // Return whether the update was successful
    return $updated;
}

// Check if the form has been submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the password from the form submission
    $password = $_POST['password'];

    // Check if the password is correct
    if ($password === 'admin123') {
        // Get the user ID from the session
        $userId = $_SESSION['user_id'];
        // Attempt to update the user's role
        if (updateUserRole($userId, 'ROLE_ADMIN')) {
            // If successful, update the session variables
            $_SESSION['role'] = 'ROLE_ADMIN';
            $_SESSION['subscription'] = 'admin';
            $_SESSION['subscription_start_date'] = date('Y-m-d');
            $_SESSION['subscription_end_date'] = date('Y-m-d', strtotime('+100 year'));
            // Redirect to the admin dashboard
            header('Location: ../security/admin/admin_dashboard.php');
            exit;
        } else {
            // If the update fails, set an error message
            $error = 'Failed to update role. Please try again.';
        }
    } else {
        // If the password is incorrect, set an error message
        $error = 'Incorrect password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Link to the Montserrat font from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Link to Tailwind config file -->
    <script src="/tailwind.config.js"></script>
    <!-- Set the favicon -->
    <link rel="icon" href="/src/favicon.ico" type="image/x-icon">
    <!-- Page title -->
    <title>Admin Sign Up</title>
</head>

<body class="bg-[url('/assets/components/hero/bg-hero-blur.png')] bg-cover bg-center bg-no-repeat bg-fixed font-montserrat text-white">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-black bg-opacity-70 p-8 rounded-lg max-w-md w-full">
            <h2 class="text-3xl font-bold mb-4">Admin Sign Up</h2>
            <!-- Display an error message if one exists -->
            <?php if (isset($error)) : ?>
                <div class="bg-red-500 text-white p-2 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <!-- Admin sign-up form -->
            <form action="admin.php" method="POST">
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="bg-gray-800 border border-gray-600 text-white rounded-lg w-full px-4 py-2 focus:outline-none" required>
                </div>
                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-gradient-to-r from-sky_primary to-rose_primary text-white px-4 py-2 rounded-lg">Submit</button>
                    <a href="/index.php" class="text-sm text-gray-400 hover:text-gray-200">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>