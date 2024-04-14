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

<body class="font-montserrat">
    <div class="absolute inset-0 bg-[url('/assets/components/hero/bg-hero.png')] bg-cover bg-center bg-no-repeat bg-fixed blur-sm"></div>

    <div class="relative z-20">
        <?php require_once '../../src/components/header/header.php'; ?>
    </div>

    <section class="container mx-auto mt-4 relative z-10">
        <div id="SignUpModal" class="flex justify-center mb-24 mt-24 items-center">
            <div class="bg-[#111418] text-white p-5 rounded-3xl relative">
                <div class="flex items-center justify-center flex-col">
                    <img src="/assets/logo.svg" alt="Logo" class="w-8">
                    <h2 class="text-lg font-bold mb-4">Sign In</h2>
                </div>
                <?php require_once '../../src/components/form/sign-in.php'; ?>
            </div>
        </div>
    </section>
</body>

</html>