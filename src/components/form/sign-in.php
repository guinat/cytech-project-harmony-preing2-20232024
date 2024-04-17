<?php session_start(); ?>

<?php if (isset($_SESSION['error_message'])) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
        <strong class="font-bold">Error !</strong>
        <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['error_message']); ?></span>
        <button onclick="this.parentElement.remove();" class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.859l-4.708-4.708 4.708-4.708a1.002 1.002 0 00-1.414-1.414l-4.708 4.708-4.708-4.708a1.002 1.002 0 10-1.414 1.414l4.708 4.708-4.708 4.708a1.002 1.002 0 001.414 1.414l4.708-4.708 4.708 4.708a1.002 1.002 0 001.414-1.414z" />
            </svg>
        </button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<form action="../../../src/security/sign-in.php" method="POST">
    <div class="mb-4">
        <label for="username" class="block text-sm font-bold mb-2">Username</label>
        <input type="text" id="username" name="username" class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white">
    </div>
    <div class="mb-6">
        <label for="password" class="block text-sm font-bold mb-2">Password</label>
        <input type="password" id="password" name="password" class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white">
    </div>
    <div class="flex flex-col items-center justify-center mb-4">
        <button class="bg-white rounded-full w-full hover:bg-gray-300 text-black font-bold py-2 px-4 focus:outline-none" type="submit">
            Submit
        </button>
    </div>
    <span class="text-sm items-left text-gray-400">Don't have an account yet ? <a class="text-sky_primary font-semibold" href="/src/pages/sign-up.php">Sign Up</a></span>

</form>