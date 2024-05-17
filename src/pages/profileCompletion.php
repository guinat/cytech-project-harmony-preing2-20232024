<?php
session_start();
// Uncomment the following line to debug and print the session variables
// echo '<pre>' . print_r($_SESSION, true) . '</pre>';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importing Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <!-- Favicon for the website -->
    <link rel="icon" href="/src/favicon.ico" type="image/x-icon">
    <title>Complete Your Profile</title>
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
            <div class="flex flex-row gap-6 items-center">
                <!-- Log Out button -->
                <a href="/src/security/logout.php" class="font-bold text-white px-4 py-2 rounded-full border-[2px] border-white">Log Out</a>
            </div>
        </div>
    </header>

    <!-- Main section for completing the profile -->
    <section class="container mx-auto px-4">
        <div class="justify-center flex">
            <h2 class="text-2xl text-white font-semibold my-5">Complete Your Profile</h2>
        </div>
        <div class="items-center justify-center flex">
            <!-- Include the form for updating the profile -->
            <?php require_once '../../src/components/form/profile.php'; ?>
        </div>
    </section>
</body>

</html>