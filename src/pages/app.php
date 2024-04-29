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
                <img src="" class="h-12 w-12 rounded-full" alt="Profile image">
                <span class="ml-3 text-sm font-semibold">Alrick</span>
            </a>
            <!-- Other elements for mobile header -->
        </div>
    </header>

    <aside class="hidden lg:block w-80 h-screen bg-dark_gray border-r border-gray-500 overflow-y-auto">

        <div class="bg-gradient-to-r from-sky_primary to-rose_primary p-2 mb-6">
            <a href="#" class="flex items-center pl-2.5 mb-5">
                <img src="path-to-your-profile-image.jpg" class="h-12 w-12 rounded-full" alt="Profile image">
                <span class="ml-3 text-sm font-semibold">Alrick</span>
            </a>
        </div>
        <div class="flex-1 flex items-center justify-center mb-6">
            <ul class="flex flex-row w-full justify-between mx-10">
                <li>
                    <span>Visitors</span>
                </li>
                <li>
                    <span>Messages</span>
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
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 justify-center flex items-center">
        <section class="container mx-auto">
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
                <div class="flex flex-row gap-12 mt-14 w-full justify-center items-center mb-12">
                    <a href="/src/pages/profileUpdate.php" class="flex flex-row gap-4 font-bold text-gray-400 px-4 py-2 rounded-xl border-[2px] border-gray-400 items-center">
                        <span>Edit Profile</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 0 1 0 1.06L4.81 8.25H15a6.75 6.75 0 0 1 0 13.5h-3a.75.75 0 0 1 0-1.5h3a5.25 5.25 0 1 0 0-10.5H4.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="/src/pages/app.php" class="flex flex-row gap-4 font-bold text-white px-4 py-2 rounded-xl border-[2px] border-white items-center">
                        <span class="text-transparent bg-clip-text bg-gradient-to-b from-sky_primary to-rose_primary">Continue</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </a>

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