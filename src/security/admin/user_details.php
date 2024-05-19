<?php
// Start the session to manage user session data
session_start();

// Check if the user is logged in and has an admin role
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
    error_log("Trying to open file: " . $filePath); // Debug message

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            // Check if the current row corresponds to the specified user ID
            if ($data[0] == $userId) {
                fclose($handle);
                error_log("User found: " . implode(", ", $data)); // Debug message
                return $data;
            }
        }
        fclose($handle);
    } else {
        error_log("File not found or unable to open: " . $filePath); // Debug message
    }
    error_log("User not found with ID: " . $userId); // Debug message
    return null;
}

// Function to retrieve user likes by user ID
function getUserLikes($userId)
{
    $likes = [];
    // Path to the profile likes CSV file
    $filePath = '../../data/profile_likes.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the current row corresponds to the specified user ID
            if ($data[0] == $userId) {
                $likes[] = $data[1];
            }
        }
        fclose($handle);
    }
    return $likes;
}

// Function to retrieve user visits by user ID
function getUserVisits($userId)
{
    $visits = [];
    // Path to the profile visits CSV file
    $filePath = '../../data/profile_visits.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the current row corresponds to the specified user ID
            if ($data[0] == $userId) {
                $visits[] = $data[1];
            }
        }
        fclose($handle);
    }
    return $visits;
}

// Function to retrieve user matches by user ID
function getUserMatches($userId)
{
    $matches = [];
    // Path to the matches CSV file
    $filePath = '../../data/matches.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the current row corresponds to the specified user ID
            if ($data[0] == $userId || $data[1] == $userId) {
                $matches[] = $data;
            }
        }
        fclose($handle);
    }
    return $matches;
}

// Function to retrieve user conversations by user ID
function getUserConversations($userId)
{
    $conversations = [];
    // Path to the conversations CSV file
    $filePath = '../../data/conversations.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the current row corresponds to the specified user ID
            if ($data[1] == $userId || $data[2] == $userId) {
                $conversations[] = $data;
            }
        }
        fclose($handle);
    }
    return $conversations;
}

// Function to retrieve messages by conversation ID
function getMessagesByConversationId($conversationId)
{
    $messages = [];
    // Path to the messages CSV file
    $filePath = '../../data/messages.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the current row corresponds to the specified conversation ID
            if ($data[1] == $conversationId) {
                $messages[] = $data;
            }
        }
        fclose($handle);
    }
    return $messages;
}

// Retrieve the current user ID from the query parameter
$currentUserId = $_GET['id'];
error_log("Current user ID: " . $currentUserId); // Debug message

// Retrieve the user information
$user = getUserById($currentUserId);

if (!$user) {
    // If the user is not found, display an error message and exit
    echo "User not found.";
    exit;
}

// Retrieve user likes, visits, matches, and conversations
$likes = getUserLikes($currentUserId);
$visits = getUserVisits($currentUserId);
$matches = getUserMatches($currentUserId);
$conversations = getUserConversations($currentUserId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
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
        <h1 class="text-3xl font-bold">User Details</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="admin_dashboard.php" class="text-white hover:underline">Back to Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="p-4">
        <div class="container mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4">Profile Information</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 text-white">
                    <tbody>
                        <!-- Display user details if available -->
                        <?php if (!empty($user[0])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>ID:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[0]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[1])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Created At:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[1]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[2])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Updated At:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[2]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[4])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Username:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[4]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[3])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Email:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[3]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[6])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Role:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[6]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[7])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>First Name:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[7]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[8])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Last Name:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[8]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[9])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Gender:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[9]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[10])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Date of Birth:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[10]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[11])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Country:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[11]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[12])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>City:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[12]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[13])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Looking For:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[13]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[14])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Music Preferences:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[14]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <!-- Display user photos if available -->
                        <?php if (!empty($user[15]) || !empty($user[16]) || !empty($user[17]) || !empty($user[18])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Photos:</strong></td>
                                <td class="border border-gray-700 p-2">
                                    <ul class="flex space-x-2">
                                        <?php if (!empty($user[15])) : ?>
                                            <li><img src="../<?php echo htmlspecialchars($user[15]); ?>" alt="Photo 1" class="w-20 h-20"></li>
                                        <?php endif; ?>
                                        <?php if (!empty($user[16])) : ?>
                                            <li><img src="../<?php echo htmlspecialchars($user[16]); ?>" alt="Photo 2" class="w-20 h-20"></li>
                                        <?php endif; ?>
                                        <?php if (!empty($user[17])) : ?>
                                            <li><img src="../<?php echo htmlspecialchars($user[17]); ?>" alt="Photo 3" class="w-20 h-20"></li>
                                        <?php endif; ?>
                                        <?php if (!empty($user[18])) : ?>
                                            <li><img src="../<?php echo htmlspecialchars($user[18]); ?>" alt="Photo 4" class="w-20 h-20"></li>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[19])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Occupation:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[19]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[20])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Smoking Status:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[20]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[21])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Hobbies:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[21]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[22])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>About Me:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[22]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[23])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Subscription:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[23]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[24])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Subscription Start Date:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[24]); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($user[25])) : ?>
                            <tr>
                                <td class="border border-gray-700 p-2"><strong>Subscription End Date:</strong></td>
                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[25]); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Links to edit or delete the user -->
            <div class="mt-4">
                <a href="edit_user.php?id=<?php echo htmlspecialchars($user[0]); ?>" class="text-blue-500 hover:underline">Edit User</a> |
                <a href="delete_user.php?id=<?php echo htmlspecialchars($user[0]); ?>" class="text-red-500 hover:underline">Delete User</a>
            </div>
        </div>

        <!-- User Likes Section -->
        <h2 class="text-2xl font-bold mt-8 mb-4">User Likes</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">Liked User ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($likes as $like) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($like); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- User Visits Section -->
        <h2 class="text-2xl font-bold mt-8 mb-4">User Visits</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">Visited User ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visits as $visit) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($visit); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- User Matches Section -->
        <h2 class="text-2xl font-bold mt-8 mb-4">User Matches</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">Matched User ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matches as $match) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($match[0] == $currentUserId ? $match[1] : $match[0]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- User Conversations Section -->
        <div class="container mx-auto p-6 bg-gray-800 rounded-lg mt-8">
            <h2 class="text-2xl font-bold mb-4">User Conversations</h2>
            <table class="min-w-full bg-gray-700 rounded-lg">
                <tbody>
                    <?php foreach ($conversations as $conversation) : ?>
                        <tr>
                            <td class="p-2">Conversation ID: <?php echo htmlspecialchars($conversation[0]); ?></td>
                            <td class="p-2">With User ID: <?php echo htmlspecialchars($conversation[1] == $currentUserId ? $conversation[2] : $conversation[1]); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="p-2">
                                <table class="min-w-full bg-gray-600 rounded-lg">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-700 p-2">Message ID</th>
                                            <th class="border border-gray-700 p-2">Sender ID</th>
                                            <th class="border border-gray-700 p-2">Message</th>
                                            <th class="border border-gray-700 p-2">Timestamp</th>
                                            <th class="border border-gray-700 p-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Retrieve messages for the current conversation
                                        $messages = getMessagesByConversationId($conversation[0]);
                                        foreach ($messages as $message) :
                                        ?>
                                            <tr>
                                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[0]); ?></td>
                                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[2]); ?></td>
                                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[3]); ?></td>
                                                <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[4]); ?></td>
                                                <td class="border border-gray-700 p-2">
                                                    <button class="text-red-500 hover:underline" onclick="deleteMessage('<?php echo htmlspecialchars($message[0]); ?>')">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

<script>
    // Function to delete a message by ID
    function deleteMessage(messageId) {
        if (confirm('Are you sure you want to delete this message?')) {
            // Send a POST request to delete the message
            fetch('../../action/delete_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'message_id=' + messageId,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Message deleted successfully.');
                        // Reload the page to reflect the changes
                        location.reload();
                    } else {
                        alert('Failed to delete message: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the message.');
                });
        }
    }
</script>