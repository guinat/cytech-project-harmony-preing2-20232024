<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importing Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>Confirmation</title>
    <style>
        /* CSS animation for fade-out effect */
        .fade-out {
            animation: fadeOut 3s forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
</head>

<body class="font-montserrat text-white bg-dark_gray">
    <!-- Header section -->
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

    <!-- Main section for confirmation message -->
    <section class="container mx-auto">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold">Thank you for subscribing!</h2>
                <p class="mb-5 font-light text-gray-500 sm:text-xl">Your subscription has been successfully activated.</p>
                <p class="mb-5 font-light text-gray-500 sm:text-xl">You will be redirected to the app in <span id="timer">5</span> seconds.</p>
            </div>
        </div>
    </section>

    <script>
        let countdown = 5; // Set the initial countdown value
        const timerElement = document.getElementById('timer'); // Get the timer element

        // Set up an interval to update the countdown every second
        const interval = setInterval(() => {
            countdown--; // Decrease the countdown value by 1
            timerElement.textContent = countdown; // Update the timer element text

            // When the countdown reaches 0, clear the interval, add the fade-out class, and redirect after the animation
            if (countdown === 0) {
                clearInterval(interval);
                document.body.classList.add('fade-out');
                setTimeout(() => {
                    window.location.href = 'app.php';
                }, 3000); // Wait for the fade-out animation to complete
            }
        }, 1000); // Interval set to 1 second
    </script>
</body>

</html>