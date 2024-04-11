<?php
session_start();
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

<body>
    <?php require_once '../../src/components/header/header.php'; ?>

    <h1>
        Welcome <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?> to Harmony
    </h1>

    <?php require_once '../../src/components/footer/footer.php'; ?>

</body>

</html>