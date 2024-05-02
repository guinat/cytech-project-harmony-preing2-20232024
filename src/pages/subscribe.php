<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>

    <title>Subscribe to Harmony</title>
</head>

<body class="font-montserrat text-white bg-dark_gray">
    <header class="justify-center items-center mx-auto">
        <div class="flex flex-col gap-4 justify-center items-center px-4 py-3 md:px-6 md:py-4 lg:px-8 lg:py-5">
            <div class="flex flex-row gap-4 items-center">
                <a href="/index.php">
                    <img src="/assets/logo_colored.svg" alt="Logo" class="w-10">
                </a>
                <div>
                    <h1 class="font-extrabold text-2xl italic">Harmony <span class="text-transparent bg-clip-text bg-gradient-to-br from-sky_primary to-rose_primary text-6xl">Pulse</span></h1>
                </div>
            </div>
        </div>
    </header>
    <section class="container mx-auto">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-left mb-8 lg:mb-12">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold">Discover your rhythm with our Pulse Plan</h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl">Unlock unlimited connections and harmonize your love life to the beat of your favorite tunes</p>
            </div>
            <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
                <label class="subscription-card relative flex flex-col p-6 mx-auto max-w-md bg-black rounded-xl border-2 border-transparent cursor-pointer">
                    <input type="radio" name="subscription" value="1week" class="hidden">
                    <div class="flex justify-between items-start">
                        <h3 class="mb-4 text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-400">1 Week</h3>
                        <span class="font-semibold text-transparent bg-clip-text bg-gradient-to-br from-sky_primary to-rose_primary">Popular</span>
                    </div>
                    <p class="font-light text-gray-500 sm:text-lg">Discover your rhythm with our Pulse Plan
                    </p>
                    <div class="flex justify-start items-baseline mt-8">
                        <span class="mr-2 text-xl font-extrabold">$8.99</span>
                        <span class="text-gray-500">/wk</span>
                    </div>
                </label>
                <label class="subscription-card relative flex flex-col p-6 mx-auto max-w-md bg-black rounded-xl border-2 border-transparent cursor-pointer">
                    <input type="radio" name="subscription" value="1month" class="hidden">
                    <div class="flex justify-between items-start">
                        <h3 class="mb-4 text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-400">1 Month</h3>
                    </div>
                    <p class="font-light text-gray-500 sm:text-lg">Discover your rhythm with our Pulse Plan
                    </p>
                    <div class="flex justify-start items-baseline mt-8">
                        <span class="mr-2 text-xl font-extrabold">$4.99</span>
                        <span class="text-gray-500">/wk</span>
                    </div>
                </label>
                <label class="subscription-card relative flex flex-col p-6 mx-auto max-w-md bg-black rounded-xl border-2 border-transparent cursor-pointer">
                    <input type="radio" name="subscription" value="6months" class="hidden">
                    <div class="flex justify-between items-start">
                        <h3 class="mb-4 text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-400">6 Months</h3>
                        <span class="font-semibold text-transparent bg-clip-text bg-gradient-to-br from-sky_primary to-rose_primary">Best value</span>
                    </div>
                    <p class="font-light text-gray-500 sm:text-lg">Discover your rhythm with our Pulse Plan
                    </p>
                    <div class="flex justify-start items-baseline mt-8">
                        <span class="mr-2 text-xl font-extrabold">$2.99</span>
                        <span class="text-gray-500">/wk</span>
                    </div>
                </label>
            </div>
        </div>
    </section>
</body>


<script>
    document.querySelectorAll('.subscription-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.subscription-card').forEach(c => {
                c.classList.remove('border-sky-300');
                c.querySelector('input[type="radio"]').checked = false;
            });
            this.classList.add('border-sky-300');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>

</html>