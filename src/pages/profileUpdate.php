<?php
session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importing Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>Update Your Profile</title>
</head>

<body class="font-montserrat text-white bg-dark_gray">
    <!-- Header section -->
    <header>
        <div class="flex justify-between items-center px-4 py-3 md:px-6 md:py-4 lg:px-8 lg:py-5">
            <div class="flex items-center">
                <a href="/index.php">
                    <img src="/assets/logo_colored.svg" alt="Logo" class="w-8">
                </a>
            </div>
            <a href="/src/pages/app.php" class="flex flex-row gap-6 items-center">
                <!-- Log Out button -->
                <span class="font-semibold text-base text-transparent bg-clip-text bg-gradient-to-br from-sky_primary to-rose_primary">Go to Harmony</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 15 6-6m0 0-6-6m6 6H9a6 6 0 0 0 0 12h3" />
                </svg>
            </a>
            <div class="flex flex-row gap-6 items-center">
                <!-- Log Out button -->
                <a href="/src/security/logout.php" class="font-bold text-white px-4 py-2 rounded-full border-[2px] border-white">Log Out</a>
            </div>

        </div>
    </header>

    <!-- Main section for completing the profile -->
    <section class="container mx-auto px-4">
        <div class="justify-center flex">
            <h2 class="text-2xl text-white font-semibold my-5">Update Your Profile</h2>
        </div>
        <div class="items-center justify-center flex">
            <!-- Include the form for updating the profile -->
            <?php require_once '../../src/components/form/update-profile.php'; ?>
        </div>
    </section>
</body>

</html>