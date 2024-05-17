<?php
// Starting session for user interaction tracking or other session-based functionality.
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Linking to Google Fonts for the Montserrat font family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Loading Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Including Tailwind CSS configuration file -->
    <script src="tailwind.config.js"></script>

    <!-- Adding favicon for the website -->
    <link rel="icon" href="src/favicon.ico" type="image/x-icon">

    <!-- Setting the title of the webpage -->
    <title>Harmony</title>
</head>

<body class="bg-[url('/assets/components/hero/bg-hero.png')] bg-cover bg-center bg-no-repeat bg-fixed font-montserrat">
    <?php
    // Including header component file
    require_once 'src/components/header/header.php';
    ?>
    <?php
    // Including hero component file
    require_once 'src/components/hero/hero.php';
    ?>
    <?php
    // Including footer component file
    require_once 'src/components/footer/footer.php';
    ?>
</body>

</html>