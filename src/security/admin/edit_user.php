<?php
// Start the session to manage user session data
session_start();

// Check if the user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ROLE_ADMIN') {
    // If not, redirect to the login page
    header('Location: ../logout.php');
    exit;
}

// Function to retrieve user information by user ID
function getUserById($userId)
{
    // Path to the users CSV file
    $filePath = '../../data/users.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the current row corresponds to the specified user ID
            if ($data[0] == $userId) {
                fclose($handle);
                return $data;
            }
        }
        fclose($handle);
    }
    return null;
}

// Function to update user information
function updateUser($userId, $updatedData)
{
    // Paths to the main users CSV file and a temporary file for updates
    $filePath = '../../data/users.csv';
    $tempFilePath = '../../data/users_temp.csv';
    $updated = false;

    // Check if the files can be opened for reading and writing
    if (($handle = fopen($filePath, 'r')) !== FALSE && ($tempHandle = fopen($tempFilePath, 'w')) !== FALSE) {
        // Copy the header row
        $header = fgetcsv($handle);
        fputcsv($tempHandle, $header);

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Update the data if the current row corresponds to the specified user ID
            if ($data[0] == $userId) {
                $data = $updatedData;
                $updated = true;
            }
            // Write the (potentially updated) row to the temporary file
            fputcsv($tempHandle, $data);
        }

        // Close both the original and temporary files
        fclose($handle);
        fclose($tempHandle);

        // Replace the original file with the updated temporary file
        if ($updated) {
            rename($tempFilePath, $filePath);
        } else {
            unlink($tempFilePath);
        }

        return $updated;
    }

    return false;
}

// Retrieve the current user ID from the query parameter
$currentUserId = $_GET['id'];

// Retrieve the user information
$user = getUserById($currentUserId);

if (!$user) {
    // If the user is not found, display an error message and exit
    echo "User not found.";
    exit;
}

// Check if the form has been submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the updated user data array from the form inputs
    $updatedData = [
        $user[0], // ID
        $user[1], // Created At
        $user[2], // Updated At
        $_POST['email'], // Email [3]
        $user[4], // Username 
        $user[5], // Password 
        $_POST['role'], // Role [6]
        $_POST['first_name'], // First Name [7]
        $_POST['last_name'], // Last Name [8]
        $_POST['gender'], // Gender [9]
        $user[10], // Date of Birth 
        $_POST['country'], // Country [11]
        $_POST['city'], // City [12]
        $_POST['looking_for'], // Looking For [13]
        $_POST['music_preferences'], // Music Preferences [14]
        $user[15], // Photos
        $user[16],
        $user[17],
        $user[18],
        $_POST['occupation'], // Occupation [19]
        $_POST['smoking_status'], // Smoking Status [20]
        $_POST['hobbies'], // Hobbies [21]
        $_POST['about_me'], // About Me [22]
        $user[22], // Subscription
        $user[23], // Subscription Start Date
        $user[24], // Subscription End Date
    ];

    // Attempt to update the user information
    if (updateUser($currentUserId, $updatedData)) {
        echo "User updated successfully.";
    } else {
        echo "Failed to update user.";
    }

    // Redirect to the admin dashboard
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
</head>

<body class="font-montserrat text-white bg-gray-900">
    <!-- Header -->
    <header class="bg-gray-800 p-4 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Edit User</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="admin_dashboard.php" class="text-white hover:underline">Back to Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="p-4">
        <!-- Form to edit user information -->
        <form method="POST">
            <div class="mb-4">
                <label for="first_name" class="block">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user[7]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="last_name" class="block">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user[8]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="email" class="block">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user[3]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="gender" class="block">Gender</label>
                <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user[9]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="country" class="block">Country</label>
                <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($user[11]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="city" class="block">City</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user[12]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="looking_for" class="block">Looking For</label>
                <input type="text" id="looking_for" name="looking_for" value="<?php echo htmlspecialchars($user[13]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="music_preferences" class="block">Music Preferences</label>
                <input type="text" id="music_preferences" name="music_preferences" value="<?php echo htmlspecialchars($user[14]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="occupation" class="block">Occupation</label>
                <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($user[19]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="smoking_status" class="block">Smoking Status</label>
                <input type="text" id="smoking_status" name="smoking_status" value="<?php echo htmlspecialchars($user[20]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="hobbies" class="block">Hobbies</label>
                <input type="text" id="hobbies" name="hobbies" value="<?php echo htmlspecialchars($user[21]); ?>" class="w-full p-2 bg-black">
            </div>
            <div class="mb-4">
                <label for="about_me" class="block">About Me</label>
                <textarea id="about_me" name="about_me" class="w-full p-2 bg-black"><?php echo htmlspecialchars($user[22]); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="role" class="block">Role</label>
                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user[6]); ?>" class="w-full p-2 bg-black">
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 bg-black rounded">Update User</button>
        </form>
    </main>
</body>

</html>