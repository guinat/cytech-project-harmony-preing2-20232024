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

    <title><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?></title>
</head>

<body class="font-montserrat text-white bg-dark_gray">
    <header class="fixed top-0 left-0 right-0">
        <div class="flex flex-col gap-4 justify-center items-center px-4 py-3 md:px-6 md:py-4 lg:px-8 lg:py-5">
            <div class="flex items-center">
                <a href="/index.php">
                    <img src="/assets/logo_colored.svg" alt="Logo" class="w-8">
                </a>
            </div>
            <div class="items-center text-center">
                <span class="font-bold text-white">
                    <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>'s Profile
                </span>
            </div>
        </div>
    </header>

    <!-- User Profile Card -->
    <section class="container mx-auto">
        <div class="flex gap-24 justify-center items-center min-h-screen">
            <div class="bg-white max-w-md md:max-w-lg rounded-xl overflow-hidden">
                <?php if ($userData) : ?>
                    <div id="carousel" class="relative">
                        <div class="flex overflow-x-hidden relative">
                            <?php for ($i = 14; $i <= 17; $i++) : ?>
                                <?php if (isset($userData[$i]) && !empty($userData[$i])) : ?>
                                    <div class="flex-none w-[380px] h-[665px] bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($userData[$i]); ?>');">
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
                                        <hr>
                                        <div class="bg-black">
                                            <div class="p-4 text-white">
                                                <p class="text-base font-semibold"><?php echo htmlspecialchars($userData[21]); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="flex justify-center p-4 gap-1 absolute top-0 left-0 right-0">
                            <?php for ($i = 14; $i <= 17; $i++) : ?>
                                <?php if (isset($userData[$i]) && !empty($userData[$i])) : ?>
                                    <div class="w-1/2 h-3 bg-gray-500 rounded-full cursor-pointer carousel-indicator" data-slide="<?php echo $i - 14; ?>"></div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <p>User information not found.</p>
                <?php endif; ?>
            </div>
            <!-- Other User Details -->
            <div class="bg-black border-2 border-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-semibold mb-4">Additional Information</h3>
                <p><strong>Occupation:</strong> <?php echo htmlspecialchars($userData[18] ?? 'N/A'); ?></p>
                <p><strong>Smoking Status:</strong> <?php echo htmlspecialchars($userData[19] ?? 'N/A'); ?></p>
                <p><strong>Harmony Score:</strong> <?php echo htmlspecialchars($userData[22] ?? 'N/A'); ?></p>
            </div>
        </div>
    </section>
</body>

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

</html>