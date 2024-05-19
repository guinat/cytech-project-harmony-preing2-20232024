<?php
session_start();
require_once '../entity/user.php';
require_once '../utils/utils.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$visitorId = $_SESSION['user_id'] ?? null;

if (!$visitorId) {
    header('Location: login.php');
    exit;
}

$user = getUser($visitorId, '../data/users.csv');

// Function to check if a user is subscribed
function isUserSubscribed($userId, $csvFilePath)
{
    $user = getUser($userId, $csvFilePath);
    return isset($user) && !empty($user) && $user->getRole() === 'ROLE_PULSE';
}

$isSubscribed = isUserSubscribed($visitorId, '../data/users.csv');

// Function to get likes given by the user
function getLikesGiven($userId, $likesFile)
{
    $likesGiven = [];
    if (($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $likesGiven[] = $data[1];
            }
        }
        fclose($handle);
    }
    return $likesGiven;
}

// Function to get likes received by the user
function getLikesReceived($userId, $likesFile)
{
    $likesReceived = [];
    if (($handle = fopen($likesFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[1] == $userId) {
                $likesReceived[] = $data[0];
            }
        }
        fclose($handle);
    }
    return $likesReceived;
}

// Function to get visits received by the user
function getVisitsReceived($userId, $visitsFile)
{
    $visitsReceived = [];
    if (($handle = fopen($visitsFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[1] == $userId) {
                $visitsReceived[] = $data[0];
            }
        }
        fclose($handle);
    }
    return $visitsReceived;
}

$likesFile = '../data/profile_likes.csv';
$visitsFile = '../data/profile_visits.csv';
$likesGiven = getLikesGiven($visitorId, $likesFile);
$likesReceived = $isSubscribed ? getLikesReceived($visitorId, $likesFile) : [];
$visitsReceived = $isSubscribed ? getVisitsReceived($visitorId, $visitsFile) : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Settings'; ?></title>
</head>

<body class="font-sans text-gray-900 bg-gray-100">
    <!-- Header section -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto py-4 px-4 flex justify-between items-center">
            <a href="/index.php">
                <img src="/assets/logo_colored.svg" alt="Logo" class="w-8 h-8">
            </a>
            <a href="app.php" class="flex gap-4 items-center">
                <span>Back</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </a>
            <span class="text-xl font-semibold">
                <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>'s Profile
            </span>
        </div>
    </header>

    <!-- Main content section -->
    <section class="container mx-auto py-10 px-4">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <nav class="bg-gray-800 text-white py-4">
                <ul class="flex justify-around">
                    <li><button id="profile-btn" class="focus:outline-none">Profile</button></li>
                    <li><a href="profileUpdate.php" class="focus:outline-none">Edit Profile</a></li>
                    <li><button id="likes-btn" class="focus:outline-none">Likes Given</button></li>
                    <?php if ($isSubscribed) : ?>
                        <li><button id="likes-received-btn" class="focus:outline-none">Likes Received</button></li>
                        <li><button id="visits-received-btn" class="focus:outline-none">Visits Received</button></li>
                    <?php endif; ?>
                    <li>
                        <a href="../security/logout.php" class="focus:outline-none">Log Out</a>
                    </li>
                </ul>
            </nav>
            <div id="profile-section" class="p-6">
                <section class="container mx-auto">
                    <div class="flex flex-col gap-10 justify-center items-center min-h-1/2 mt-10">
                        <div class="bg-white max-w-md md:max-w-lg rounded-xl overflow-hidden">
                            <!-- Check if user data is available -->
                            <?php if ($user) : ?>
                                <!-- Carousel for user photos -->
                                <div id="carousel" class="relative">
                                    <div class="flex overflow-x-hidden relative">
                                        <!-- Loop through specific indexes to display user photos -->
                                        <?php for ($i = 0; $i <= 3; $i++) : ?>
                                            <?php if (isset($user->getPhotos()[$i]) && !empty($user->getPhotos()[$i])) : ?>
                                                <div class="flex-none w-[290px] h-[565px] md:w-[330px] md:h-[615px] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($user->getPhotos()[$i]); ?>');">
                                                    <div class="flex h-full items-end bg-gradient-to-t from-black via-transparent">
                                                        <div class="p-4 text-white">
                                                            <h2 class="text-3xl font-bold"><?php echo htmlspecialchars($user->getFirstName()); ?></h2>
                                                            <div class="text-sm flex gap-2 items-center mb-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                                    <path fill-rule="evenodd" d="M19.952 1.651a.75.75 0 0 1 .298.599V16.303a3 3 0 0 1-2.176 2.884l-1.32.377a2.553 2.553 0 1 1-1.403-4.909l2.311-.66a1.5 1.5 0 0 0 1.088-1.442V6.994l-9 2.572v9.737a3 3 0 0 1-2.176 2.884l-1.32.377a2.553 2.553 0 1 1-1.402-4.909l2.31-.66a1.5 1.5 0 0 0 1.088-1.442V5.25a.75.75 0 0 1 .544-.721l10.5-3a.75.75 0 0 1 .658.122Z" clip-rule="evenodd" />
                                                                </svg>
                                                                <p><?php echo htmlspecialchars($user->getMusicPreferences()); ?></p>
                                                            </div>
                                                            <div class="text-sm flex gap-2 items-center mb-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                                </svg>
                                                                <p><?php echo htmlspecialchars($user->getCity()); ?></p>
                                                            </div>
                                                            <div class="text-sm flex gap-2 items-center mb-0">
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
                                                            <p class="text-xs font-semibold">Occupation: <?php echo htmlspecialchars($user->getOccupation() ?? 'N/A'); ?></p>
                                                            <p class="text-xs font-semibold">Smoking Status: <?php echo htmlspecialchars($user->getSmokingStatus() ?? 'N/A'); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="flex justify-center p-4 gap-1 absolute top-0 left-0 right-0">
                                        <!-- Carousel indicators -->
                                        <?php for ($i = 0; $i <= 3; $i++) : ?>
                                            <?php if (isset($user->getPhotos()[$i]) && !empty($user->getPhotos()[$i])) : ?>
                                                <div class="w-1/2 h-2.5 bg-gray-500 rounded-full cursor-pointer carousel-indicator" data-slide="<?php echo $i; ?>"></div>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <p>User data not available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>
            <div id="likes-section" class="hidden p-6">
                <h2 class="text-2xl font-bold mb-4">Likes Given</h2>
                <?php if (count($likesGiven) > 0) : ?>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <?php foreach ($likesGiven as $likedUserId) : ?>
                            <?php
                            $likedUser = getUser($likedUserId, '../data/users.csv');
                            $likedUserPhoto = htmlspecialchars($likedUser->getPhotos()[0]);
                            ?>
                            <div class="relative">
                                <a href="/profile.php?id=<?php echo $likedUserId; ?>">
                                    <img src="<?php echo $likedUserPhoto; ?>" alt="Profile Photo of <?php echo htmlspecialchars($likedUser->getFirstName() . ' ' . $likedUser->getLastName()); ?>" class="w-full h-32 md:h-40 lg:h-48 rounded-lg object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg">
                                        <span class="text-white text-xl font-bold"><?php echo htmlspecialchars($likedUser->getFirstName()); ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p>You have not liked any profiles yet.</p>
                <?php endif; ?>
            </div>
            <?php if ($isSubscribed) : ?>
                <div id="likes-received-section" class="hidden p-6">
                    <h2 class="text-2xl font-bold mb-4">Likes Received</h2>
                    <?php if (count($likesReceived) > 0) : ?>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <?php foreach ($likesReceived as $likerUserId) : ?>
                                <?php
                                $likerUser = getUser($likerUserId, '../data/users.csv');
                                $likerUserPhoto = htmlspecialchars($likerUser->getPhotos()[0]);
                                ?>
                                <div class="relative">
                                    <a href="/profile.php?id=<?php echo $likerUserId; ?>">
                                        <img src="<?php echo $likerUserPhoto; ?>" alt="Profile Photo of <?php echo htmlspecialchars($likerUser->getFirstName() . ' ' . $likerUser->getLastName()); ?>" class="w-full h-32 md:h-40 lg:h-48 rounded-lg object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg">
                                            <span class="text-white text-xl font-bold"><?php echo htmlspecialchars($likerUser->getFirstName()); ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p>No one has liked your profile yet.</p>
                    <?php endif; ?>
                </div>
                <div id="visits-received-section" class="hidden p-6">
                    <h2 class="text-2xl font-bold mb-4">Visits Received</h2>
                    <?php if (count($visitsReceived) > 0) : ?>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <?php foreach ($visitsReceived as $visitorUserId) : ?>
                                <?php
                                $visitorUser = getUser($visitorUserId, '../data/users.csv');
                                $visitorPhoto = htmlspecialchars($visitorUser->getPhotos()[0]);
                                ?>
                                <div class="relative">
                                    <a href="/profile.php?id=<?php echo $visitorUserId; ?>">
                                        <img src="<?php echo $visitorPhoto; ?>" alt="Profile Photo of <?php echo htmlspecialchars($visitorUser->getFirstName() . ' ' . $visitorUser->getLastName()); ?>" class="w-full h-32 md:h-40 lg:h-48 rounded-lg object-cover">
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg">
                                            <span class="text-white text-xl font-bold"><?php echo htmlspecialchars($visitorUser->getFirstName()); ?></span>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p>No one has visited your profile yet.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
        const indicators = document.querySelectorAll('.carousel-indicator');
        indicators.forEach((indicator, i) => {
            indicator.addEventListener('click', () => {
                const slides = document.querySelectorAll('#carousel .flex-none');
                slides.forEach(slide => slide.classList.add('hidden'));
                slides[i].classList.remove('hidden');

                indicators.forEach(ind => ind.classList.replace('bg-white', 'bg-gray-500'));
                indicator.classList.replace('bg-gray-500', 'bg-white');
            });
        });

        // Auto click the first indicator on load
        indicators.length > 0 && indicators[0].click();

        document.getElementById('profile-btn').addEventListener('click', function() {
            document.getElementById('profile-section').classList.remove('hidden');
            document.getElementById('likes-section').classList.add('hidden');
            <?php if ($isSubscribed) : ?>
                document.getElementById('likes-received-section').classList.add('hidden');
                document.getElementById('visits-received-section').classList.add('hidden');
            <?php endif; ?>
        });

        document.getElementById('likes-btn').addEventListener('click', function() {
            document.getElementById('profile-section').classList.add('hidden');
            document.getElementById('likes-section').classList.remove('hidden');
            <?php if ($isSubscribed) : ?>
                document.getElementById('likes-received-section').classList.add('hidden');
                document.getElementById('visits-received-section').classList.add('hidden');
            <?php endif; ?>
        });

        <?php if ($isSubscribed) : ?>
            document.getElementById('likes-received-btn').addEventListener('click', function() {
                document.getElementById('profile-section').classList.add('hidden');
                document.getElementById('likes-section').classList.add('hidden');
                document.getElementById('likes-received-section').classList.remove('hidden');
                document.getElementById('visits-received-section').classList.add('hidden');
            });

            document.getElementById('visits-received-btn').addEventListener('click', function() {
                document.getElementById('profile-section').classList.add('hidden');
                document.getElementById('likes-section').classList.add('hidden');
                document.getElementById('likes-received-section').classList.add('hidden');
                document.getElementById('visits-received-section').classList.remove('hidden');
            });
        <?php endif; ?>
    </script>
</body>

</html>