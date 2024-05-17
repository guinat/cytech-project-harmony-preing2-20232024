<header class="flex justify-between items-center mb-6 px-4 py-3 md:px-6 md:py-4 lg:px-8 lg:py-5">
    <!-- Logo and brand name -->
    <div class="flex items-center">
        <!-- Link to home page with logo -->
        <a href="/index.php">
            <img src="/assets/logo.svg" alt="Logo" class="w-8">
        </a>
        <!-- Link to home page with brand name (visible on medium screens and above) -->
        <a href="/index.php">
            <span class="hidden md:flex text-2xl font-bold text-white ml-2">Harmony</span>
        </a>
    </div>

    <!-- Navigation links (visible on medium screens and above) -->
    <div class="hidden md:flex flex-row gap-10 items-center">
        <a href="#" class="font-bold text-gray-400">Language</a>
        <a href="#" class="font-bold text-gray-400">Learn more</a>
    </div>

    <!-- Login and Sign Up links -->
    <div class="flex flex-row gap-6 items-center">
        <!-- Link to login page -->
        <a href="/src/pages/signIn.php" class="font-bold text-white">Login</a>
        <!-- Link to sign up page with additional styling -->
        <a href="/src/pages/signUp.php" class="font-bold text-white px-4 py-2 rounded-full border-[2px] border-white">Sign Up</a>
    </div>
</header>