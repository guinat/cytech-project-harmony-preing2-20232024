<?php
session_start();
echo '
    <pre>' . print_r($_SESSION, true) . '</pre>';
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

<body class="bg-gray-100">
    <?php require_once '/src/components/header/header.php'; ?>


    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-semibold text-gray-800 my-5">Update Your Profile</h2>
        <?php require_once '/src/components/form/update-profile.php'; ?>
    </div>

    <?php require_once '/src/components/footer/footer.php'; ?>

</body>

</html>