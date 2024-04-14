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

<form action="../../../src/security/sign-up.php" method="POST">
    <div class="mb-4">
        <label for="username" class="block text-sm font-bold mb-2">Username <span class="font-bold text-red-600">*</span></label>
        <input type="text" id="username" name="username" class=" bg-[#111418] border border-gray-400 rounded-full w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-6">
        <label for="password" class="block text-ghttp://localhost:8000/templates/pages/sign-up.phpray-700 text-sm font-bold mb-2">Password <span class="font-bold text-red-600">*</span></label>
        <input type="password" id="password" name="password" class=" bg-[#111418] border border-gray-400 rounded-full w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-6">
        <label for="confirm_password" class="block text-sm font-bold mb-2">Confirm password <span class="font-bold text-red-600">*</span></label>
        <input type="password" id="confirm_password" name="confirm_password" class=" bg-[#111418] border border-gray-400 rounded-full w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="text-sm text-gray-400 flex flex-col mb-4">
        <span>Password must be at least 8 characters</span>
        <span>Password must contain a symbol</span>
        <span>Password must contain a number</span>
    </div>
    <div class="flex flex-col items-center justify-center mb-4">
        <button class="bg-white rounded-full w-full hover:bg-gray-100 text-[#111418] font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="submit">
            Submit
        </button>
    </div>
    <span class="text-sm items-left text-gray-400">Have an account yet ? <a class="text-sky-300" href="/src/pages/sign-in.php">Sign In</a></span>
</form>