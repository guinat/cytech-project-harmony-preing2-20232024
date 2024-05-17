<?php
session_start();
require_once '../entity/user.php';
require_once '../utils/utils.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Retrieve user ID from the query parameter and visitor ID from the session
$userId = $_GET['id'] ?? null;
$visitorId = $_SESSION['user_id'] ?? null;
$user = $userId ? getUser($userId, '../data/users.csv') : null;

// If user and visitor IDs are valid, log the profile visit
if ($user && $visitorId) {
    try {
        logProfileVisit($visitorId, $userId);
    } catch (Exception $e) {
        echo "Error logging profile visit: " . $e->getMessage();
    }
}

// If user is not found, display an error message and exit
if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importing Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>User Profile</title>
</head>

<body class="font-montserrat text-white bg-black lg:flex lg:min-h-screen">
    <section class="container mx-auto">
        <div class="flex flex-col gap-10 justify-center items-center min-h-1/2 mt-10">
            <div class="bg-white max-w-md md:max-w-lg rounded-xl overflow-hidden">
                <?php if ($user) : ?>
                    <!-- Carousel for user photos -->
                    <div id="carousel" class="relative">
                        <div class="flex overflow-x-hidden relative">
                            <!-- Loop through user photos and display them -->
                            <?php foreach ($user->getPhotos() as $photo) : ?>
                                <?php if (!empty($photo)) : ?>
                                    <div class="flex-none w-[290px] h-[565px] md:w-[330px] md:h-[615px] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($photo); ?>');">
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
                            <?php endforeach; ?>
                        </div>
                        <!-- Carousel indicators -->
                        <div class="flex justify-center p-4 gap-1 absolute top-0 left-0 right-0">
                            <?php foreach ($user->getPhotos() as $index => $photo) : ?>
                                <?php if (!empty($photo)) : ?>
                                    <div class="w-1/2 h-2.5 bg-gray-500 rounded-full cursor-pointer carousel-indicator" data-slide="<?php echo $index; ?>"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Message if user information is not found -->
                    <p>User information not found.</p>
                <?php endif; ?>
            </div>
            <!-- Alert container for errors -->
            <div id="alert-container" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline" id="alert-message"></span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg id="close-alert" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1 1 0 0 1-1.415 0L10 11.415l-2.933 2.934a1 1 0 1 1-1.415-1.415l2.934-2.933-2.934-2.933a1 1 0 1 1 1.415-1.415L10 8.586l2.933-2.934a1 1 0 0 1 1.416 1.416L11.416 10l2.933 2.933a1 1 0 0 1-1.416 1.416z" />
                    </svg>
                </span>
            </div>
            <!-- Like button -->
            <button id="like-button" class="flex flex-row gap-4 font-bold text-white px-4 py-2 rounded-xl border-[2px] border-white items-center bg-gradient-to-r from-rose_primary to-sky_primary">
                <span>Like</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </section>

    <script>
        // Carousel functionality for indicators
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

        // Like button functionality
        document.getElementById('like-button').addEventListener('click', function() {
            fetch('/src/security/like_profile.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'liker_id=<?php echo $_SESSION["user_id"]; ?>&liked_id=<?php echo $user->getId(); ?>'
                }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.href = '/src/pages/app.php';
                    } else {
                        const alertContainer = document.getElementById('alert-container');
                        const alertMessage = document.getElementById('alert-message');
                        alertMessage.innerText = data.message;
                        alertContainer.classList.remove('hidden');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
        });

        // Close alert functionality
        document.getElementById('close-alert').addEventListener('click', function() {
            document.getElementById('alert-container').classList.add('hidden');
        });
    </script>
</body>

</html>