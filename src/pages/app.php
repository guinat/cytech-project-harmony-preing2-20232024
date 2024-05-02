<?php
session_start();

function getUserById($userId, $csvFilePath)
{
    if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                fclose($handle);
                return $data;
            }
        }
        fclose($handle);
    }
    return null;
}

$userData = null;
$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    $userData = getUserById($userId, '../data/users.csv');
}

function getLastThreeUsers($csvFilePath, $currentUserId)
{
    $users = [];
    if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] !== $currentUserId) {
                array_push($users, $data);
            }
        }
        fclose($handle);
    }
    return array_slice(array_reverse($users), 0, 3);
}

$currentUser = $_SESSION['user_id'] ?? null;
$users = getLastThreeUsers('../data/users.csv', $currentUser);
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
                    <img src="<?php echo htmlspecialchars($userData[14]); ?>" class="object-cover">
                </div>
                <span class="ml-3 text-xs uppercase font-bold"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?></span>
            </div>
            <div class="bg-black bg-opacity-60 rounded-full flex items-center justify-center w-5 h-5 p-3">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M8.34 1.804A1 1 0 0 1 9.32 1h1.36a1 1 0 0 1 .98.804l.295 1.473c.497.144.971.342 1.416.587l1.25-.834a1 1 0 0 1 1.262.125l.962.962a1 1 0 0 1 .125 1.262l-.834 1.25c.245.445.443.919.587 1.416l1.473.294a1 1 0 0 1 .804.98v1.361a1 1 0 0 1-.804.98l-1.473.295a6.95 6.95 0 0 1-.587 1.416l.834 1.25a1 1 0 0 1-.125 1.262l-.962.962a1 1 0 0 1-1.262.125l-1.25-.834a6.953 6.953 0 0 1-1.416.587l-.294 1.473a1 1 0 0 1-.98.804H9.32a1 1 0 0 1-.98-.804l-.295-1.473a6.957 6.957 0 0 1-1.416-.587l-1.25.834a1 1 0 0 1-1.262-.125l-.962-.962a1 1 0 0 1-.125-1.262l.834-1.25a6.957 6.957 0 0 1-.587-1.416l-1.473-.294A1 1 0 0 1 1 10.68V9.32a1 1 0 0 1 .804-.98l1.473-.295c.144-.497.342-.971.587-1.416l-.834-1.25a1 1 0 0 1 .125-1.262l.962-.962A1 1 0 0 1 5.38 3.03l1.25.834a6.957 6.957 0 0 1 1.416-.587l.294-1.473ZM13 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>


        </div>


        <!-- <div class="flex-1 flex items-center justify-center mb-6">
            <ul class="flex flex-row w-full justify-between mx-10">
                <li>
                    <span class="font-semibold text-base">Visitors</span>
                </li>
                <li>
                    <span class="font-semibold text-base">Messages</span>
                </li>
            </ul>
        </div>
        <div class="flex items-center p-4 bg-gray-700 rounded-lg shadow-md">
            <div class="mx-auto text-center">
                <svg class="h-8 w-8 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                </svg>
                <p class="text-xs mt-2">Say Hello</p>
                <p class="text-xs">Want to start a conversation?</p>
            </div>
        </div> -->
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
                    <?php if ($userData) : ?>
                        <div id="carousel" class="relative">
                            <div class="flex overflow-x-hidden relative">
                                <?php for ($i = 14; $i <= 17; $i++) : ?>
                                    <?php if (isset($userData[$i]) && !empty($userData[$i])) : ?>
                                        <div class="flex-none w-[290px] h-[565px]  md:w-[330px] md:h-[615px] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($userData[$i]); ?>');">
                                            <div class="flex h-full items-end bg-gradient-to-t from-black via-transparent">
                                                <div class="p-4 text-white">
                                                    <h2 class="text-3xl font-bold"><?php echo htmlspecialchars($userData[6]); ?></h2>
                                                    <div class="text-sm flex gap-2 items-center mb-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd" d="M19.952 1.651a.75.75 0 0 1 .298.599V16.303a3 3 0 0 1-2.176 2.884l-1.32.377a2.553 2.553 0 1 1-1.403-4.909l2.311-.66a1.5 1.5 0 0 0 1.088-1.442V6.994l-9 2.572v9.737a3 3 0 0 1-2.176 2.884l-1.32.377a2.553 2.553 0 1 1-1.402-4.909l2.31-.66a1.5 1.5 0 0 0 1.088-1.442V5.25a.75.75 0 0 1 .544-.721l10.5-3a.75.75 0 0 1 .658.122Z" clip-rule="evenodd" />
                                                        </svg>
                                                        <p><?php echo htmlspecialchars($userData[13]); ?></p>
                                                    </div>
                                                    <div class="text-sm flex gap-2 items-center mb-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                                        </svg>
                                                        <p><?php echo htmlspecialchars($userData[11]); ?></p>
                                                    </div>
                                                    <div class="text-sm flex gap-2 items-center mb-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                            <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                                        </svg>
                                                        <p><?php echo htmlspecialchars($userData[20]); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full border-b border-gray-500"></div>
                                            <div class="bg-black">
                                                <div class="p-4 text-white">
                                                    <p class="text-base italic font-semibold"><?php echo htmlspecialchars($userData[21]); ?></p>
                                                </div>
                                                <div class="w-full border-b border-gray-500"></div>
                                                <div class="p-4 text-white">
                                                    <h3 class="text-sm uppercase font-semibold mb-4">Additional Information</h3>
                                                    <p class="text-xs font-semibold">Occupation: <?php echo htmlspecialchars($userData[18] ?? 'N/A'); ?></p>
                                                    <p class="text-xs font-semibold">Smoking Status: <?php echo htmlspecialchars($userData[19] ?? 'N/A'); ?></p>
                                                    <p class="text-xs font-semibold">Harmony Score: <?php echo htmlspecialchars($userData[22] ?? 'N/A'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="flex justify-center p-4 gap-1 absolute top-0 left-0 right-0">
                                <?php for ($i = 14; $i <= 17; $i++) : ?>
                                    <?php if (isset($userData[$i]) && !empty($userData[$i])) : ?>
                                        <div class="w-1/2 h-2.5 bg-gray-500 rounded-full cursor-pointer carousel-indicator" data-slide="<?php echo $i - 14; ?>"></div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <p>User information not found.</p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-row gap-48 items-center">
                    <div class="border-2 border-white rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="border-2 border-white rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

        </section>
    </main>
</body>

</html>
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

    indicators.length > 0 && indicators[0].click();
</script>