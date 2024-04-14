<?php
session_start();
// echo '
//     <pre>' . print_r($_SESSION, true) . '</pre>';
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>Complete Your Profile</title>
</head>

<body class="bg-[#111418]">
    <header>
        <div class="flex justify-between items-center px-4 py-3 md:px-6 md:py-4 lg:px-8 lg:py-5">
            <div class="flex items-center">
                <a href="/index.php">
                    <img src="/assets/logo.svg" alt="Logo" class="w-8">
                </a>
            </div>
            <div class="flex flex-row gap-6 items-center">
                <a href="/src/security/logout.php" class="font-bold text-white px-4 py-2 rounded-full border-[2px] border-white">Log Out</a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4">
        <div class="justify-center flex">
            <h2 class="text-2xl text-white font-semibold my-5">Complete Your Profile</h2>
        </div>
        <?php require_once '../../src/components/form/profile.php'; ?>
    </div>
</body>

</html>