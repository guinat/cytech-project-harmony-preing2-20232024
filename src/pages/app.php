<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


include_once '../entity/user.php';

function getUsersFromCSV($csvFilePath, $excludeUserId = null)
{
    $users = [];
    if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
        fgetcsv($handle);
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $excludeUserId) {
                continue;
            }
            $user = new UserEntity($data[0], $data[3], $data[4]);
            $user->getId($data[1]);
            $user->setFirstName($data[6]);
            $user->setLastName($data[7]);
            $user->setGender($data[8]);
            $user->setDateOfBirth($data[9]);
            $user->setCountry($data[10]);
            $user->setCity($data[11]);
            $user->setLookingFor($data[12]);
            $user->setMusicPreferences($data[13]);
            $user->setPhotos(array_slice($data, 14, 4));
            $user->setOccupation($data[18]);
            $user->setSmokingStatus($data[19]);
            $user->setHobbies($data[20]);
            $user->setAboutMe($data[21]);
            $users[] = $user;
        }
        fclose($handle);
    }

    usort($users, function ($a, $b) {
        return $b->getId() - $a->getId();
    });

    return array_slice($users, 0, 20);
}

$currentUserId = $_SESSION['user_id'] ?? null;
$lastUsers = getUsersFromCSV('../data/users.csv', $currentUserId);


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
                <img src="<?php echo htmlspecialchars($userData[14]); ?>" class="flex w-10 h-10 rounded-full object-cover"></img>
                <span class="ml-3 text-xs uppercase font-bold"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?></span>
            </a>
            <!-- Other elements for mobile header -->
        </div>
    </header>

    <aside class="relative hidden lg:block w-80 h-screen bg-black border-r border-gray-500 overflow-y-auto">

        <div class="bg-gradient-to-r from-sky_primary to-rose_primary flex items-center justify-between p-5 mb-6">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 border-2 border-white  rounded-full overflow-hidden">
                    <img src="<?php echo isset($_SESSION['user_photos']['photo1']) ? htmlspecialchars($_SESSION['user_photos']['photo1']) : '/path/to/default/image.png'; ?>" class="object-cover">
                </div>
                <span class="ml-3 text-xs uppercase font-bold"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['form_values']['first_name']) : ''; ?></span>
            </div>
            <div class="bg-black bg-opacity-60 rounded-full flex items-center justify-center w-5 h-5 p-3">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M8.34 1.804A1 1 0 0 1 9.32 1h1.36a1 1 0 0 1 .98.804l.295 1.473c.497.144.971.342 1.416.587l1.25-.834a1 1 0 0 1 1.262.125l.962.962a1 1 0 0 1 .125 1.262l-.834 1.25c.245.445.443.919.587 1.416l1.473.294a1 1 0 0 1 .804.98v1.361a1 1 0 0 1-.804.98l-1.473.295a6.95 6.95 0 0 1-.587 1.416l.834 1.25a1 1 0 0 1-.125 1.262l-.962.962a1 1 0 0 1-1.262.125l-1.25-.834a6.953 6.953 0 0 1-1.416.587l-.294 1.473a1 1 0 0 1-.98.804H9.32a1 1 0 0 1-.98-.804l-.295-1.473a6.957 6.957 0 0 1-1.416-.587l-1.25.834a1 1 0 0 1-1.262-.125l-.962-.962a1 1 0 0 1-.125-1.262l.834-1.25a6.957 6.957 0 0 1-.587-1.416l-1.473-.294A1 1 0 0 1 1 10.68V9.32a1 1 0 0 1 .804-.98l1.473-.295c.144-.497.342-.971.587-1.416l-.834-1.25a1 1 0 0 1 .125-1.262l.962-.962A1 1 0 0 1 5.38 3.03l1.25.834a6.957 6.957 0 0 1 1.416-.587l.294-1.473ZM13 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>


        </div>
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

    </aside>

    <!-- Main content -->
    <main class="flex-1 justify-center flex items-center bg-dark_gray">
        <section class="container mx-auto">
            <form class="flex items-center max-w-sm lg:max-w-md mx-auto mt-8 lg:mt-0">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" id="simple-search" class="bg-black border border-medium_gray text-white text-sm rounded-lg block w-full ps-3 p-2.5" placeholder="Search for users..." />
                </div>
                <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-gradient-to-r from-sky_primary to-rose_primary rounded-lg border-2 border-white focus:outline-none">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
            <div class="flex flex-col gap-10 justify-center items-center min-h-1/2 mt-10">
                <div class="bg-white max-w-md md:max-w-lg rounded-xl overflow-hidden">
                    <div id="carousel" class="relative">
                        <div class="flex overflow-x-hidden relative">
                            <?php foreach ($lastUsers as $userIndex => $user) : ?>
                                <div class="user-card flex-none w-[290px] h-[565px] md:w-[330px] md:h-[615px] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($user->getPhotos()[0]); ?>');">
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
                                            <p class="text-xs font-semibold">Harmony Score: <?php echo htmlspecialchars($user->getHarmony()); ?></p>
                                        </div>
                                    </div>
                                </div>
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
        </section>

    </main>

</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            if (currentIndex < userCards.length - 1) {
                currentIndex++;
                displayCurrentCard();
            }
        });

        prevButton.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                displayCurrentCard();
            }
        });
    });
</script>