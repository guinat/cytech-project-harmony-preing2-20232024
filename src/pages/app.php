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

<body class="font-montserrat text-white bg-dark_gray">
    <header class="justify-center items-center mx-auto">
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

    <section class="container mx-auto">

    </section>
</body>



</html>