<?php session_start();
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
    <script src="tailwind.config.js"></script>

    <link rel="icon" href="src/favicon.ico" type="image/x-icon">
    <title>Harmony</title>
</head>

<body class="bg-[url('/assets/components/hero/bg-hero-2.jpeg')] bg-cover bg-center bg-no-repeat bg-fixed font-montserrat">
    <?php require_once 'src/components/header/header.php'; ?>
    <?php require_once 'src/components/hero/hero.php'; ?>
    <?php require_once 'src/components/footer/footer.php'; ?>
</body>

</html>