<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>

    <link rel="icon" href="/src/favicon.ico" type="image/x-icon">
    <title>Sign In</title>
</head>

<body class="font-montserrat bg-gray-600">
    <?php require_once '../../src/components/header/header.php'; ?>

    <section class="container mx-auto mt-4">
        <div id="SignUpModal" class="flex justify-center mb-24 mt-24 items-center">
            <div class="border border-black p-5 rounded-lg relative">
                <h2 class="text-lg font-bold mt-4 mb-4">Sign In to Harmony</h2>
                <?php require_once '../../src/components/form/sign-in.php'; ?>
            </div>
        </div>
    </section>
</body>

</html>