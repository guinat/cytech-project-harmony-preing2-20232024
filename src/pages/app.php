<?php
session_start(); // Start the session

// Redirect to the profile completion page if the first name is not set or is empty
if (!isset($_SESSION['first_name']) || empty($_SESSION['first_name'])) {
    header('Location: ../pages/profileCompletion.php');
    exit;
}

ini_set('display_errors', 1); // Enable error display
error_reporting(E_ALL); // Report all types of errors

include_once '../entity/user.php'; // Include the User entity class

// Function to check if the user is subscribed
function isSubscribed($user)
{
    return $user->getSubscription();
}

// Function to get the list of users liked by the current user
function getLikedUsers($userId)
{
    $likedUsers = [];
    $likesFile = '../data/profile_likes.csv';
    if (file_exists($likesFile) && ($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $likedUsers[] = $data[1];
            }
        }
        fclose($handle);
    }
    return $likedUsers;
}

// Function to get the list of users from a CSV file, excluding the current user and blocked users
function getUsersFromCSV($csvFilePath, $excludeUserId = null)
{
    $users = [];
    $blockedUsers = getBlockedUsers($excludeUserId);

    if (file_exists($csvFilePath) && ($handle = fopen($csvFilePath, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $excludeUserId || in_array($data[0], $blockedUsers)) {
                continue;
            }

            $user = new UserEntity($data[0], $data[3], $data[4]);
            if (isset($data[0])) $user->getId($data[0]);
            if (isset($data[6])) $user->setFirstName($data[6]);
            if (isset($data[7])) $user->setLastName($data[7]);
            if (isset($data[8])) $user->setGender($data[8]);
            if (isset($data[9])) $user->setDateOfBirth($data[9]);
            if (isset($data[10])) $user->setCountry($data[10]);
            if (isset($data[11])) $user->setCity($data[11]);
            if (isset($data[12])) $user->setLookingFor($data[12]);
            if (isset($data[13])) $user->setMusicPreferences($data[13]);
            if (isset($data[14])) $user->setPhotos(array_slice($data, 14, 4));
            if (isset($data[18])) $user->setOccupation($data[18]);
            if (isset($data[19])) $user->setSmokingStatus($data[19]);
            if (isset($data[20])) $user->setHobbies($data[20]);
            if (isset($data[21])) $user->setAboutMe($data[21]);
            if (isset($data[22])) $user->setSubscription($data[22]);
            if (isset($data[23])) $user->setSubscriptionStartDate($data[23]);
            if (isset($data[24])) $user->setSubscriptionEndDate($data[24]);
            $users[] = $user;
        }
        fclose($handle);
    }

    // Sort users by ID in descending order
    usort($users, function ($a, $b) {
        return $b->getId() - $a->getId();
    });

    return array_slice($users, 0, 20); // Return the top 20 users
}

// Function to get the list of blocked users
function getBlockedUsers($userId)
{
    $blockedUsers = [];
    $blockedUsersFile = '../data/blocked_users.csv';

    if (file_exists($blockedUsersFile) && ($handle = fopen($blockedUsersFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId || $data[1] == $userId) {
                $blockedUsers[] = ($data[0] == $userId) ? $data[1] : $data[0];
            }
        }
        fclose($handle);
    }

    return $blockedUsers;
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

// Function to get mutual likes for the current user
function getMutualLikes($userId)
{
    $mutualLikes = [];
    $likesFile = '../data/profile_likes.csv';
    $matchesFile = '../data/matches.csv';
    $userLikes = [];
    $likedByUsers = [];
    $currentDateTime = date('Y-m-d H:i:s');

    // Ouvrir le fichier des likes
    if (file_exists($likesFile) && ($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $userLikes[] = $data[1];
            }
            if ($data[1] == $userId) {
                $likedByUsers[] = $data[0];
            }
        }
        fclose($handle);
    }

    // Ouvrir le fichier des matchs en mode ajout
    $matchesHandle = fopen($matchesFile, 'a');
    if ($matchesHandle === FALSE) {
        error_log('Failed to open matches file for appending: ' . $matchesFile);
        return $mutualLikes; // Retourner les likes mutuels même si l'écriture échoue
    }

    // Trouver les likes mutuels et écrire les matchs dans le fichier CSV
    foreach ($userLikes as $likedUserId) {
        if (in_array($likedUserId, $likedByUsers)) {
            $mutualLikes[] = $likedUserId;
            // Écrire le match dans le fichier CSV
            fputcsv($matchesHandle, [$userId, $likedUserId, $currentDateTime]);
        }
    }

    fclose($matchesHandle);

    return $mutualLikes;
}


$currentUserId = $_SESSION['user_id'] ?? null; // Get the current user ID from the session
$lastUsers = getUsersFromCSV('../data/users.csv', $currentUserId); // Get the latest users excluding the current user

$mutualLikes = getMutualLikes($currentUserId); // Get mutual likes for the current user
$matchedUsers = array_filter($lastUsers, function ($user) use ($mutualLikes) {
    return in_array($user->getId(), $mutualLikes);
});

$user = getUser($currentUserId, '../data/users.csv'); // Get the current user
$conversations = getConversations($currentUserId); // Get the conversations for the current user

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>Harmony</title>
</head>

<body class="font-montserrat text-white bg-black lg:flex lg:min-h-screen">
    <!-- Header for small screens -->
    <header class="bg-dark_gray border-b border-gray-500 text-white p-4 lg:hidden">
        <div class="flex items-center justify-between">
            <!-- Mobile header content -->
            <a href="#" class="flex items-center">
                <img src="<?php echo htmlspecialchars($user->getPhotos()[0] ?? ''); ?>" class="flex w-10 h-10 rounded-full object-cover">
                <span class="ml-3 text-xs uppercase font-bold"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?></span>
            </a>
            <!-- Other elements for mobile header -->
        </div>
    </header>

    <!-- Sidebar for large screens -->
    <aside class="relative hidden lg:block w-80 h-screen bg-black border-r border-gray-500 overflow-y-auto">
        <div class="bg-gradient-to-r from-sky_primary to-rose_primary flex items-center justify-between p-5 mb-6">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 border-2 border-white rounded-full overflow-hidden">
                    <img src="<?php echo isset($_SESSION['photos']['1']) ? htmlspecialchars($_SESSION['photos']['1']) : ''; ?>" class="object-cover">
                </div>
                <span class="ml-3 text-xs uppercase font-bold <?php echo $user->getSubscription() ? 'bg-clip-text text-transparent bg-gradient-to-br from-sky_primary to-rose_primary drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,1)]' : 'text-red-900 text-extrabold'; ?>">
                    <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['first_name']) : ''; ?>
                </span>
            </div>
            <div class="bg-black bg-opacity-60 rounded-full flex items-center justify-center w-5 h-5 p-3">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 0 1-.517.608 7.45 7.45 0 0 0-.478.198.798.798 0 0 1-.796-.064l-.453-.324a1.875 1.875 0 0 0-2.416.2l-.243.243a1.875 1.875 0 0 0-.2 2.416l.324.453a.798.798 0 0 1 .064.796 7.448 7.448 0 0 0-.198.478.798.798 0 0 1-.608.517l-.55.092a1.875 1.875 0 0 0-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 0 1-.064.796l-.324.453a1.875 1.875 0 0 0 .2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 0 1 .796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 0 1 .517-.608 7.52 7.52 0 0 0 .478-.198.798.798 0 0 1 .796.064l.453.324a1.875 1.875 0 0 0 2.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 0 1-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 0 0 1.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 0 1-.608-.517 7.507 7.507 0 0 0-.198-.478.798.798 0 0 1 .064-.796l.324-.453a1.875 1.875 0 0 0-.2-2.416l-.243-.243a1.875 1.875 0 0 0-2.416-.2l-.453.324a.798.798 0 0 1-.796.064 7.462 7.462 0 0 0-.478-.198.798.798 0 0 1-.517-.608l-.091-.55a1.875 1.875 0 0 0-1.85-1.566h-.344ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
        </div>
        <?php if (isSubscribed($user)) : ?>
            <div class="flex-1 flex items-center justify-center mb-6">
                <ul class="flex flex-row w-full justify-between mx-10">
                    <li id="matchs-tab" class="active-tab underline decoration-wavy decoration-gradient">
                        <span class="font-semibold text-base cursor-pointer">Matchs</span>
                    </li>
                    <li id="messages-tab">
                        <span class="font-semibold text-base cursor-pointer">Messages</span>
                    </li>
                </ul>
            </div>
            <div id="matchs-content" class="flex flex-wrap gap-4 justify-center items-center min-h-1/2 mt-10">
                <?php if ($matchedUsers) : ?>
                    <?php foreach ($matchedUsers as $matchedUser) : ?>
                        <a href="#" class="matched-profile w-24 h-24 bg-cover bg-center rounded-xl" style="background-image: url('<?php echo htmlspecialchars($matchedUser->getPhotos()[0]); ?>');" data-user-id="<?php echo $matchedUser->getId(); ?>">
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-white">No matched profiles found.</p>
                <?php endif; ?>
            </div>
            <div id="recent-conversations-content" class="hidden flex flex-col gap-10 justify-center items-center min-h-1/2 mt-10">
                <?php if ($conversations) : ?>
                    <?php foreach ($conversations as $conversation) : ?>
                        <div class="conversation p-4 bg-black rounded shadow cursor-pointer" data-conversation-id="<?php echo $conversation[0]; ?>" data-user-id="<?php echo ($conversation[1] == $currentUserId) ? $conversation[2] : $conversation[1]; ?>">
                            Conversation with <?php echo ($conversation[1] == $currentUserId) ? getUser($conversation[2], '../data/users.csv')->getFirstName() : getUser($conversation[1], '../data/users.csv')->getFirstName(); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="text-white">No conversations found.</p>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- No Subs view -->
            <div class="absolute left-0 right-0 top-1/3 mb-6">
                <div class="flex mx-4 items-center">
                    <span class="font-bold text-xl text-left w-full mb-4">Subscribe to unlock all features</span>
                </div>
                <!-- CARD -->
                <div class="flex justify-center items-center mb-4">
                    <a href="/src/pages/subscribe.php" class="relative bg-dark_gray w-full mx-4 h-fit rounded-xl shadow-md p-4">
                        <div class="flex flex-col gap-2 justify-start">
                            <div class="flex flex-row gap-1 ml-2">
                                <img class="w-6 h-auto" src="/assets/logo_colored.svg" alt="logo">
                                <h1 class="font-extrabold text-xl italic">Harmony <span class="text-transparent bg-clip-text bg-gradient-to-br from-sky_primary to-rose_primary text-2xl">Pulse</span></h1>
                            </div>
                            <span class="ml-2 text-medium_gray text-base font-semibold">
                                Level up on harmony
                            </span>
                        </div>
                        <span class="absolute top-[-4px] right-0">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gradient-to-br from-sky_primary to-rose_primary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-gradient-to-br from-sky_primary to-rose_primary"></span>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </aside>

    <!-- Main content -->
    <main class="flex-1 justify-center flex items-center bg-dark_gray">
        <!-- PROFILE -->
        <section class="container mx-auto" id="main-content">
            <form id="search-form" class="flex items-center max-w-sm lg:max-w-md mx-auto mt-8 lg:mt-0">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" name="keyword" id="simple-search" class="bg-black border border-medium_gray text-white text-sm rounded-lg block w-full ps-3 p-2.5" placeholder="Search for users..." />
                </div>
                <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-gradient-to-r from-sky_primary to-rose_primary rounded-lg border-2 border-white focus:outline-none">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
            <div id="results" class="mt-4"></div>
            <div id="initial-content" class="flex flex-col gap-10 justify-center items-center min-h-1/2 mt-10">
                <div class="bg-white max-w-md md:max-w-lg rounded-xl overflow-hidden">
                    <div id="carousel" class="relative">
                        <div class="flex overflow-x-hidden relative">
                            <?php foreach ($lastUsers as $userIndex => $user) : ?>
                                <a href="profile.php?id=<?php echo htmlspecialchars($user->getId()); ?>" class="user-card flex-none w-[290px] h-[565px] md:w-[330px] md:h-[615px] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($user->getPhotos()[0]); ?>');">
                                    <div class="profile-info flex h-full items-end bg-gradient-to-t from-black via-transparent">
                                        <div class="p-4 text-white">
                                            <h2 class="text-3xl font-bold"><?php echo htmlspecialchars($user->getFirstName()); ?></h2>
                                            <div class="text-sm flex gap-2 items-center mb-0 text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd" d="M19.952 1.651a.75.75 0 0 1 .298.599V16.303a3 3 0 0 1-2.176 2.884l-1.32.377a2.553 2.553 0 1 1-1.403-4.909l2.311-.66a1.5 1.5 0 0 0 1.088-1.442V6.994l-9 2.572v9.737a3 3 0 0 1-2.176 2.884l-1.32.377a2.553 2.553 0 1 1-1.402-4.909l2.31-.66a1.5 1.5 0 0 0 1.088-1.442V5.25a.75.75 0 0 1 .544-.721l10.5-3a.75.75 0 0 1 .658.122Z" clip-rule="evenodd" />
                                                </svg>
                                                <p><?php echo is_array($user->getMusicPreferences()) ? implode(', ', $user->getMusicPreferences()) : htmlspecialchars($user->getMusicPreferences()); ?></p>
                                            </div>
                                            <div class="text-sm flex gap-2 items-center mb-0 text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                </svg>
                                                <p><?php echo htmlspecialchars($user->getCity()); ?></p>
                                            </div>
                                            <div class="text-sm flex gap-2 items-center mb-0 text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                    <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                                </svg>
                                                <p><?php echo htmlspecialchars($user->getHobbies()); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full border-b border-gray-500"></div>
                                    <div class="bg-black">
                                        <div class="p-4 text-white">
                                            <p class="text-base italic font-semibold"><?php echo htmlspecialchars($user->getAboutMe()); ?></p>
                                        </div>
                                        <div class="w-full border-b border-gray-500"></div>
                                        <div class="p-4 text-white">
                                            <h3 class="text-sm uppercase font-semibold mb-4">Additional Information</h3>
                                            <p class="text-xs font-semibold">Occupation: <?php echo htmlspecialchars($user->getOccupation()); ?></p>
                                            <p class="text-xs font-semibold">Smoking Status: <?php echo htmlspecialchars($user->getSmokingStatus()); ?></p>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row gap-24 mx-auto">
                    <button id="prev" class="border-2 border-white rounded-full p-3 opacity-100 disabled:opacity-50 disabled:cursor-not-allowed disabled:border-gray-700 disabled:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <button id="next" class="border-2 border-white rounded-full p-3 opacity-100 disabled:opacity-50 disabled:cursor-not-allowed disabled:border-gray-700 disabled:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>

                </div>
            </div>
        </section>
        <!-- CONVERSATIONS -->
        <section class="container mx-auto justify-center flex items-center" id="conversations-content" style="display: none;">
            <div class="bg-white max-w-md md:max-w-lg rounded-xl overflow-hidden">
                <div class="flex justify-between p-4">
                    <button id="close-conversation" class="text-gray-500 hover:text-gray-700">&times; Close</button>
                    <div class="flex space-x-2">
                        <button id="report-profile" class="bg-yellow-500 text-white p-2 rounded-lg">Signaler</button>
                        <button id="block-profile" class="bg-red-500 text-white p-2 rounded-lg">Bloquer</button>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row">
                    <div class="flex-1 max-h-[75vh] overflow-y-auto p-4 space-y-4">
                        <div id="messages-list">
                            <!-- Messages will be loaded here via AJAX -->
                        </div>
                        <form id="message-form" class="flex bg-gray-200">
                            <input type="text" id="message-input" class="flex-1 p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-blue-500" placeholder="Type a message...">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-lg">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Report User Modal -->
        <div id="report-user-modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg max-w-md w-full">
                <h2 id="modal-title" class="text-xl font-bold mb-4">Signaler le profil</h2>
                <p id="modal-content" class="mb-4">Êtes-vous sûr de vouloir signaler ce profil?</p>
                <label for="report-reason" class="block mb-2">Raison:</label>
                <select id="report-reason" class="w-full mb-4 p-2 border rounded">
                    <option value="harassment">Harcèlement</option>
                    <option value="spam">Spam</option>
                    <option value="inappropriate">Contenu inapproprié</option>
                    <option value="other">Autre</option>
                </select>
                <input type="text" id="other-report-reason" class="w-full mb-4 p-2 border rounded hidden" placeholder="Votre raison">
                <div class="flex justify-end">
                    <button id="cancel-report-user" class="bg-gray-300 text-gray-700 p-2 rounded mr-2">Annuler</button>
                    <button id="confirm-report-user" class="bg-yellow-500 text-white p-2 rounded">Signaler</button>
                </div>
            </div>
        </div>

        <!-- Block User Modal -->
        <div id="block-user-modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
            <div class="bg-white p-6 rounded-lg max-w-md w-full">
                <h2 id="modal-title" class="text-xl font-bold mb-4">Block User</h2>
                <p id="modal-content" class="mb-4">Are you sure you want to block this user?</p>
                <label for="block-reason" class="block mb-2">Reason:</label>
                <select id="block-reason" class="w-full mb-4 p-2 border rounded">
                    <option value="spam">Spam</option>
                    <option value="harassment">Harassment</option>
                    <option value="inappropriate">Inappropriate Content</option>
                    <option value="other">Other</option>
                </select>
                <input type="text" id="other-reason" class="w-full mb-4 p-2 border rounded hidden" placeholder="Enter your reason">
                <div class="flex justify-end">
                    <button id="cancel-block-user" class="bg-gray-300 text-gray-700 p-2 rounded mr-2">Cancel</button>
                    <button id="confirm-block-user" class="bg-red-500 text-white p-2 rounded">Block</button>
                </div>
            </div>
        </div>


    </main>



</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded');

        const matchesTab = document.getElementById('matchs-tab');
        const messagesTab = document.getElementById('messages-tab');
        const matchesContent = document.getElementById('matchs-content');
        const recentConversationsContent = document.getElementById('recent-conversations-content');
        const mainContent = document.getElementById('main-content');
        const conversationsContent = document.getElementById('conversations-content');
        const closeConversationButton = document.getElementById('close-conversation');
        const reportButton = document.getElementById('report-profile');
        const blockButton = document.getElementById('block-profile');

        const reportModal = document.getElementById('report-user-modal');
        const blockModal = document.getElementById('block-user-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalContent = document.getElementById('modal-content');
        const cancelActionButton = document.getElementById('cancel-block-user');
        const confirmActionButton = document.getElementById('confirm-block-user');

        let conversationRefreshInterval;
        let currentAction;
        let currentUserId;
        let currentConversationId;

        matchesTab.addEventListener('click', function() {
            console.log('Matches tab clicked');
            matchesTab.classList.add('underline', 'decoration-wavy', 'decoration-gradient');
            messagesTab.classList.remove('underline', 'decoration-wavy', 'decoration-gradient');
            matchesContent.classList.remove('hidden');
            recentConversationsContent.classList.add('hidden');
            mainContent.style.display = 'block';
            conversationsContent.style.display = 'none'; // Masquer le contenu de la conversation
            clearInterval(conversationRefreshInterval); // Arrêter le rafraîchissement de la conversation
            loadMatches();
        });

        function loadMatches() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../action/get_matches.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const matches = JSON.parse(xhr.responseText);
                        console.log('Matches loaded:', matches);
                        matchesContent.innerHTML = '';
                        matches.forEach(match => {
                            const matchElement = document.createElement('a');
                            matchElement.href = '#';
                            matchElement.className = 'matched-profile w-24 h-24 bg-cover bg-center rounded-xl';
                            matchElement.style.backgroundImage = `url('${match.photos[0]}')`;
                            matchElement.dataset.userId = match.id;
                            matchesContent.appendChild(matchElement);
                        });
                        addMatchClickListeners();
                    } catch (error) {
                        console.error('Failed to parse JSON:', error);
                        console.error('Response:', xhr.responseText);
                    }
                } else {
                    console.error('Failed to load matches:', xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();
        }

        function addMatchClickListeners() {
            document.querySelectorAll('.matched-profile').forEach(profile => {
                profile.addEventListener('click', function(event) {
                    event.preventDefault();
                    const userId = this.dataset.userId;
                    currentUserId = userId;
                    console.log('Matched profile clicked, User ID:', userId);
                    startConversation(userId);
                });
            });
        }

        loadMatches();

        messagesTab.addEventListener('click', function() {
            console.log('Messages tab clicked');
            messagesTab.classList.add('underline', 'decoration-wavy', 'decoration-gradient');
            matchesTab.classList.remove('underline', 'decoration-wavy', 'decoration-gradient');
            matchesContent.classList.add('hidden');
            recentConversationsContent.classList.remove('hidden');
            mainContent.style.display = 'block';
            conversationsContent.style.display = 'none';
            clearInterval(conversationRefreshInterval); // Arrêter le rafraîchissement de la conversation
            updateConversationsList();
        });

        function updateConversationsList() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../action/get_conversations.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const conversations = JSON.parse(xhr.responseText);
                        console.log('Conversations loaded:', conversations);
                        recentConversationsContent.innerHTML = '';
                        conversations.forEach(conversation => {
                            const conversationElement = document.createElement('div');
                            conversationElement.className = 'conversation p-4 bg-black rounded shadow cursor-pointer';
                            conversationElement.dataset.conversationId = conversation.id;
                            conversationElement.dataset.userId = conversation.userId;
                            conversationElement.innerText = `Conversation with ${conversation.userName}`;
                            recentConversationsContent.appendChild(conversationElement);
                        });
                        addConversationClickListeners();
                    } catch (error) {
                        console.error('Failed to parse JSON:', error);
                        console.error('Response:', xhr.responseText);
                    }
                } else {
                    console.error('Failed to load conversations:', xhr.statusText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();
        }

        function addConversationClickListeners() {
            document.querySelectorAll('.conversation').forEach(conversation => {
                conversation.addEventListener('click', function() {
                    const conversationId = this.dataset.conversationId;
                    const userId = this.dataset.userId;
                    currentUserId = userId;
                    currentConversationId = conversationId;
                    console.log('Conversation clicked, ID:', conversationId);
                    loadConversation(conversationId);
                });
            });
        }

        closeConversationButton.addEventListener('click', function() {
            console.log('Close conversation clicked');
            mainContent.style.display = 'block';
            conversationsContent.style.display = 'none';
            clearInterval(conversationRefreshInterval);
        });

        reportButton.addEventListener('click', function() {
            const reportReasonSelect = document.getElementById('report-reason');
            const otherReportReasonInput = document.getElementById('other-report-reason');

            reportReasonSelect.value = 'harassment';
            otherReportReasonInput.classList.add('hidden');
            reportModal.classList.remove('hidden');

            reportReasonSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherReportReasonInput.classList.remove('hidden');
                } else {
                    otherReportReasonInput.classList.add('hidden');
                }
            });

            const confirmReportButton = document.getElementById('confirm-report-user');
            confirmReportButton.addEventListener('click', function() {
                const reason = reportReasonSelect.value === 'other' ? otherReportReasonInput.value : reportReasonSelect.value;

                reportProfile(currentUserId, reason);
                reportModal.classList.add('hidden');
            });

            const cancelReportButton = document.getElementById('cancel-report-user');
            cancelReportButton.addEventListener('click', function() {
                reportModal.classList.add('hidden');
            });
        });

        function reportProfile(userId, reason) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../action/report_profile.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Profile reported:', userId);
                    location.reload();
                } else {
                    console.error('Error reporting profile:', xhr.statusText, xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send('user_id=' + userId + '&reason=' + encodeURIComponent(reason));
        }

        blockButton.addEventListener('click', function() {
            currentAction = 'block';
            modalTitle.textContent = 'Bloquer le profil';
            modalContent.innerHTML = `
            <p>Êtes-vous sûr de vouloir bloquer ce profil ?</p>
            <select id="block-reason" class="w-full p-2 border rounded">
                <option value="harassment">Harcèlement</option>
                <option value="spam">Spam</option>
                <option value="inappropriate">Contenu inapproprié</option>
                <option value="other">Autre</option>
            </select>
            <input type="text" id="other-reason" class="w-full p-2 border rounded hidden" placeholder="Votre raison">
        `;
            blockModal.classList.remove('hidden');

            const blockReasonSelect = document.getElementById('block-reason');
            const otherReasonInput = document.getElementById('other-reason');

            blockReasonSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherReasonInput.classList.remove('hidden');
                } else {
                    otherReasonInput.classList.add('hidden');
                }
            });

            const confirmBlockButton = document.getElementById('confirm-block-user');
            confirmBlockButton.addEventListener('click', function() {
                const reason = blockReasonSelect.value === 'other' ? otherReasonInput.value : blockReasonSelect.value;
                blockProfile(currentUserId, currentConversationId, reason);
                blockModal.classList.add('hidden');
            });

            const cancelBlockButton = document.getElementById('cancel-block-user');
            cancelBlockButton.addEventListener('click', function() {
                blockModal.classList.add('hidden');
            });
        });

        function blockProfile(userId, conversationId, reason) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../action/block_profile.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Profile blocked:', userId);
                    mainContent.style.display = 'block';
                    conversationsContent.style.display = 'none';
                    location.reload();
                } else {
                    console.error('Error blocking profile:', xhr.statusText, xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send('user_id=' + userId + '&conversation_id=' + conversationId + '&reason=' + encodeURIComponent(reason));
        }


        function startConversation(userId) {
            console.log('Starting conversation with user ID:', userId);
            messagesTab.classList.add('underline', 'decoration-wavy', 'decoration-gradient');
            matchesTab.classList.remove('underline', 'decoration-wavy', 'decoration-gradient');
            matchesContent.classList.add('hidden');
            recentConversationsContent.classList.remove('hidden');
            mainContent.style.display = 'none';
            conversationsContent.style.display = 'block';

            let conversationId = null;
            document.querySelectorAll('.conversation').forEach(conversation => {
                if (conversation.getAttribute('data-user-id') == userId) {
                    conversationId = conversation.getAttribute('data-conversation-id');
                }
            });

            if (conversationId) {
                console.log('Existing conversation found, ID:', conversationId);
                loadConversation(conversationId);
            } else {
                console.log('No existing conversation, creating new');
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../action/start_conversation.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    console.log('start_conversation response status:', xhr.status);
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            console.log('Parsed response:', response);
                            loadConversation(response.conversation_id);
                            currentConversationId = response.conversation_id;
                            updateConversationsList(); // Add this line
                        } catch (e) {
                            console.error('Error parsing JSON:', e, xhr.responseText);
                        }
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                };
                xhr.send('user_id=' + userId);
            }
        }

        function loadConversation(conversationId) {
            console.log('Loading conversation ID:', conversationId);
            mainContent.style.display = 'none';
            conversationsContent.style.display = 'block';
            recentConversationsContent.classList.remove('hidden');

            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../action/get_messages.php?conversation_id=' + conversationId, true);
            xhr.onload = function() {
                console.log('get_messages response status:', xhr.status);
                if (xhr.status === 200) {
                    try {
                        const messages = JSON.parse(xhr.responseText);
                        console.log('Parsed messages:', messages);
                        const messagesList = document.getElementById('messages-list');
                        messagesList.innerHTML = '';
                        messages.forEach(message => {
                            const messageElement = document.createElement('div');
                            messageElement.classList.add('flex', 'items-end', 'space-y-4');
                            if (message.sender_id == <?php echo json_encode($currentUserId); ?>) {
                                messageElement.classList.add('justify-end');
                                messageElement.innerHTML = `
                                <div class="relative bg-blue-500 text-white p-2 rounded-lg max-w-xs">
                                    <p>${message.message_text}</p>
                                    <small class="text-xs">${message.timestamp}</small>
                                    <button class="absolute top-0 right-0 text-white bg-red-500 rounded-full p-1 m-1 delete-message" data-message-id="${message.message_id}">
                                        &times;
                                    </button>
                                </div>
                            `;
                            } else {
                                messageElement.classList.add('justify-start');
                                messageElement.innerHTML = `
                                <div class="bg-gray-300 text-black p-2 rounded-lg max-w-xs">
                                    <p>${message.message_text}</p>
                                    <small class="text-xs">${message.timestamp}</small>
                                </div>
                            `;
                            }
                            messagesList.appendChild(messageElement);
                        });
                        document.querySelectorAll('.conversation').forEach(conversation => {
                            conversation.classList.remove('active');
                        });
                        const activeConversation = document.querySelector(`.conversation[data-conversation-id="${conversationId}"]`);
                        if (activeConversation) {
                            activeConversation.classList.add('active');
                        }
                        addDeleteMessageListeners();
                    } catch (e) {
                        console.error('Error parsing JSON:', e, xhr.responseText);
                    }
                } else {
                    console.error('Error:', xhr.statusText, xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send();

            clearInterval(conversationRefreshInterval);
            conversationRefreshInterval = setInterval(function() {
                const activeConversation = document.querySelector('.conversation.active');
                if (activeConversation) {
                    loadConversation(conversationId);
                }
            }, 5000);
        }

        function addDeleteMessageListeners() {
            document.querySelectorAll('.delete-message').forEach(button => {
                button.addEventListener('click', function() {
                    const messageId = this.getAttribute('data-message-id');
                    console.log('Delete message clicked, ID:', messageId);
                    deleteMessage(messageId);
                });
            });
        }

        function deleteMessage(messageId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../action/delete_message.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Message deleted:', messageId);
                    const activeConversation = document.querySelector('.conversation.active');
                    if (activeConversation) {
                        loadConversation(activeConversation.getAttribute('data-conversation-id'));
                    }
                } else {
                    console.error('Error deleting message:', xhr.statusText, xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send('message_id=' + messageId);
        }

        document.getElementById('message-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value;
            console.log('Message form submitted, message:', message);

            if (message.trim() === '') return;

            const activeConversation = document.querySelector('.conversation.active');
            const conversationId = activeConversation ? activeConversation.getAttribute('data-conversation-id') : currentConversationId;

            if (!conversationId) {
                console.error('No active conversation found.');
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../action/send_message.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('send_message response status:', xhr.status);
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Parsed response:', response);
                        if (response.status === 'success') {
                            loadConversation(conversationId);
                            messageInput.value = '';
                        } else {
                            console.error('Error:', response.message);
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e, xhr.responseText);
                    }
                } else {
                    console.error('Error:', xhr.statusText, xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('Request failed');
            };
            xhr.send('conversation_id=' + conversationId + '&message=' + encodeURIComponent(message));
        });

        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var keyword = document.getElementById('simple-search').value;
            console.log('Searching for:', keyword);

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'search.php?keyword=' + encodeURIComponent(keyword), true);

            xhr.onload = function() {
                console.log('search response status:', xhr.status);
                if (xhr.status === 200) {
                    console.log('Response received:', xhr.responseText);
                    document.getElementById('results').innerHTML = xhr.responseText;
                    document.getElementById('initial-content').style.display = 'none';
                } else {
                    console.error('Error:', xhr.statusText, xhr.responseText);
                    document.getElementById('results').innerHTML = '<p>An error occurred while processing your request. Please try again. Error: ' + xhr.statusText + '</p>';
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
                document.getElementById('results').innerHTML = '<p>An error occurred while processing your request. Please try again.</p>';
            };

            xhr.send();
        });

        const userCards = document.querySelectorAll('.user-card');
        let currentIndex = 0;

        const nextButton = document.getElementById('next');
        const prevButton = document.getElementById('prev');

        function updateButtonStates() {
            prevButton.disabled = currentIndex === 0;
            nextButton.disabled = currentIndex === userCards.length - 1;
        }

        function displayCurrentCard() {
            userCards.forEach((card, index) => {
                card.style.display = index === currentIndex ? 'block' : 'none';
            });
            updateButtonStates();
        }

        displayCurrentCard();

        nextButton.addEventListener('click', () => {
            console.log('Next button clicked');
            if (currentIndex < userCards.length - 1) {
                currentIndex++;
                displayCurrentCard();
            }
        });

        prevButton.addEventListener('click', () => {
            console.log('Prev button clicked');
            if (currentIndex > 0) {
                currentIndex--;
                displayCurrentCard();
            }
        });
    });
</script>