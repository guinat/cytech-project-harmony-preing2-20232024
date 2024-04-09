<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: welcome.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>Sign In</title>
</head>

<body>
    <?php require_once '../../src/components/header/header.php'; ?>

    <section class="container mx-auto mt-4">
        <div id="SignUpModal" class="flex justify-center mb-24 mt-24 items-center">
            <div class="border border-black p-5 rounded-lg relative">
                <h2 class="text-lg font-bold mt-4 mb-4">Sign In to Harmony</h2>
                <?php require_once '../../src/components/form/sign-in.php'; ?>
            </div>
        </div>
    </section>

    <?php require_once '../../src/components/footer/footer.php'; ?>

</body>

</html>