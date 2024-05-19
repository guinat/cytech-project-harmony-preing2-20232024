<?php
// Start the session to manage user session data
session_start();

// Check if the user is logged in and is an administrator
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ROLE_ADMIN') {
    // If not, redirect to the login page
    header('Location: ../logout.php');
    exit;
}

// Function to retrieve all users except the logged-in admin
function getAllUsers()
{
    $users = [];
    $filePath = '../../data/users.csv';
    $adminUserId = $_SESSION['user_id']; // ID of the logged-in admin user

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        // Loop through each row in the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Check if the user ID is not the admin's ID
            if ($data[0] != $adminUserId) {
                $users[] = $data;
            }
        }
        fclose($handle);
    }
    return $users;
}

// Function to retrieve all deleted messages
function getDeletedMessages()
{
    $messages = [];
    $filePath = '../../data/deleted_messages.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        // Loop through each row in the CSV file and collect the messages
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $messages[] = $data;
        }
        fclose($handle);
    }
    return $messages;
}

// Function to retrieve all deleted conversations
function getDeletedConversations()
{
    $conversations = [];
    $filePath = '../../data/deleted_conversations.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        // Loop through each row in the CSV file and collect the conversations
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $conversations[] = $data;
        }
        fclose($handle);
    }
    return $conversations;
}

// Retrieve deleted messages and conversations
$deletedMessages = getDeletedMessages();
$deletedConversations = getDeletedConversations();

// Function to retrieve all reports
function getAllReports()
{
    $reports = [];
    $filePath = '../../data/reported_profiles.csv';

    // Check if the file exists and open it for reading
    if (file_exists($filePath) && ($handle = fopen($filePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip the header row

        // Loop through each row in the CSV file and collect the reports
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $reports[] = $data;
        }
        fclose($handle);
    }
    return $reports;
}

// Retrieve all reports and users
$reports = getAllReports();
$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <a href="/src/pages/app.php" class="flex gap-2 items-center">
            <span>Back to Harmony</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
            </svg>
        </a>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="#" id="users-tab" class="text-white hover:underline">Users</a></li>
                <li><a href="#" id="reports-tab" class="text-white hover:underline">Reports</a></li>
                <li><a href="#" id="deleted-messages-tab" class="text-white hover:underline">Deleted Messages</a></li>
                <li><a href="#" id="deleted-conversations-tab" class="text-white hover:underline">Deleted Conversations</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="p-4">
        <!-- Users Management -->
        <section id="users-section">
            <h2 class="text-2xl font-bold mb-4">Users Management</h2>
            <table class="w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">ID</th>
                        <th class="border border-gray-700 p-2">First Name</th>
                        <th class="border border-gray-700 p-2">Last Name</th>
                        <th class="border border-gray-700 p-2">Email</th>
                        <th class="border border-gray-700 p-2">Role</th>
                        <th class="border border-gray-700 p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[0]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[7]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[8]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[3]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($user[6]); ?></td>
                            <td class="border border-gray-700 p-2">
                                <a href="user_details.php?id=<?php echo htmlspecialchars($user[0]); ?>" class="text-blue-500 hover:underline">View</a> |
                                <a href="edit_user.php?id=<?php echo htmlspecialchars($user[0]); ?>" class="text-blue-500 hover:underline">Edit</a> |
                                <a href="#" class="text-red-500 hover:underline" onclick="confirmDelete('<?php echo htmlspecialchars($user[0]); ?>', '<?php echo htmlspecialchars($user[3]); ?>')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Reports Management -->
        <section id="reports-section" class="hidden">
            <h2 class="text-2xl font-bold mb-4">Reports Management</h2>
            <table class="w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">Reporter ID</th>
                        <th class="border border-gray-700 p-2">Reported User ID</th>
                        <th class="border border-gray-700 p-2">Reported At</th>
                        <th class="border border-gray-700 p-2">Reason</th>
                        <th class="border border-gray-700 p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($report[0]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($report[1]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($report[2]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($report[3]); ?></td>
                            <td class="border border-gray-700 p-2">
                                <a href="user_details.php?id=<?php echo htmlspecialchars($report[1]); ?>" class="text-blue-500 hover:underline">View User</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Deleted Messages -->
        <section id="deleted-messages-section" class="hidden">
            <h2 class="text-2xl font-bold mb-4">Deleted Messages</h2>
            <table class="w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">Message ID</th>
                        <th class="border border-gray-700 p-2">Conversation ID</th>
                        <th class="border border-gray-700 p-2">Sender ID</th>
                        <th class="border border-gray-700 p-2">Message Text</th>
                        <th class="border border-gray-700 p-2">Timestamp</th>
                        <th class="border border-gray-700 p-2">Deleted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deletedMessages as $message) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[0]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[1]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[2]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[3]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[4]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($message[5]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Deleted Conversations -->
        <section id="deleted-conversations-section" class="hidden">
            <h2 class="text-2xl font-bold mb-4">Deleted Conversations</h2>
            <table class="w-full bg-gray-800 text-white">
                <thead>
                    <tr>
                        <th class="border border-gray-700 p-2">Conversation ID</th>
                        <th class="border border-gray-700 p-2">User 1 ID</th>
                        <th class="border border-gray-700 p-2">User 2 ID</th>
                        <th class="border border-gray-700 p-2">Conversation Start</th>
                        <th class="border border-gray-700 p-2">Conversation End</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deletedConversations as $conversation) : ?>
                        <tr>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($conversation[0]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($conversation[1]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($conversation[2]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($conversation[3]); ?></td>
                            <td class="border border-gray-700 p-2"><?php echo htmlspecialchars($conversation[4]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Confirmation Modal -->
        <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg max-w-md w-full">
                <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                <p class="mb-4">Are you sure you want to delete this user?</p>
                <label class="block mb-4">
                    <input type="checkbox" id="blacklistEmail" class="mr-2"> Blacklist this email
                </label>
                <div class="flex justify-end">
                    <button id="cancelBtn" class="bg-gray-300 text-gray-700 p-2 rounded mr-2">Cancel</button>
                    <button id="confirmBtn" class="bg-red-500 text-white p-2 rounded">Delete</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let userIdToDelete;
        let userEmailToDelete;

        // Function to confirm user deletion
        function confirmDelete(userId, userEmail) {
            userIdToDelete = userId;
            userEmailToDelete = userEmail;
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        // Event listener to cancel the deletion
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('confirmModal').classList.add('hidden');
        });

        // Event listener to confirm the deletion and blacklist if needed
        document.getElementById('confirmBtn').addEventListener('click', function() {
            const blacklistEmail = document.getElementById('blacklistEmail').checked;
            let url = `delete_user.php?id=${userIdToDelete}`;
            if (blacklistEmail) {
                url += `&blacklist=${userEmailToDelete}`;
            }
            window.location.href = url;
        });

        // Tab navigation event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const usersTab = document.getElementById('users-tab');
            const reportsTab = document.getElementById('reports-tab');
            const deletedMessagesTab = document.getElementById('deleted-messages-tab');
            const deletedConversationsTab = document.getElementById('deleted-conversations-tab');
            const usersSection = document.getElementById('users-section');
            const reportsSection = document.getElementById('reports-section');
            const deletedMessagesSection = document.getElementById('deleted-messages-section');
            const deletedConversationsSection = document.getElementById('deleted-conversations-section');

            usersTab.addEventListener('click', function(event) {
                event.preventDefault();
                usersSection.classList.remove('hidden');
                reportsSection.classList.add('hidden');
                deletedMessagesSection.classList.add('hidden');
                deletedConversationsSection.classList.add('hidden');
                usersTab.classList.add('underline');
                reportsTab.classList.remove('underline');
                deletedMessagesTab.classList.remove('underline');
                deletedConversationsTab.classList.remove('underline');
            });

            reportsTab.addEventListener('click', function(event) {
                event.preventDefault();
                usersSection.classList.add('hidden');
                reportsSection.classList.remove('hidden');
                deletedMessagesSection.classList.add('hidden');
                deletedConversationsSection.classList.add('hidden');
                reportsTab.classList.add('underline');
                usersTab.classList.remove('underline');
                deletedMessagesTab.classList.remove('underline');
                deletedConversationsTab.classList.remove('underline');
            });

            deletedMessagesTab.addEventListener('click', function(event) {
                event.preventDefault();
                usersSection.classList.add('hidden');
                reportsSection.classList.add('hidden');
                deletedMessagesSection.classList.remove('hidden');
                deletedConversationsSection.classList.add('hidden');
                deletedMessagesTab.classList.add('underline');
                usersTab.classList.remove('underline');
                reportsTab.classList.remove('underline');
                deletedConversationsTab.classList.remove('underline');
            });

            deletedConversationsTab.addEventListener('click', function(event) {
                event.preventDefault();
                usersSection.classList.add('hidden');
                reportsSection.classList.add('hidden');
                deletedMessagesSection.classList.add('hidden');
                deletedConversationsSection.classList.remove('hidden');
                deletedConversationsTab.classList.add('underline');
                usersTab.classList.remove('underline');
                reportsTab.classList.remove('underline');
                deletedMessagesTab.classList.remove('underline');
            });
        });
    </script>
</body>

</html>