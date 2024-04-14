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
        <input type="text" id="username" name="username" class="bg-[#111418] border border-gray-400 rounded-full w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-6">
        <label for="password" class="block text-sm font-bold mb-2">Password <span class="font-bold text-red-600">*</span></label>
        <input type="password" id="password" name="password" class="bg-[#111418] border border-gray-400 rounded-full w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-6">
        <label for="confirm_password" class="block text-sm font-bold mb-2">Confirm Password <span class="font-bold text-red-600">*</span></label>
        <input type="password" id="confirm_password" name="confirm_password" class="bg-[#111418] border border-gray-400 rounded-full w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline">
        <div id="passwordCheck" class="text-sm text-gray-400"></div>
    </div>
    <div class="text-sm text-gray-400 flex flex-col mb-4" id="passwordCriteria">
        <span id="length">At least 8 characters</span>
        <span id="uppercase">Includes an uppercase letter</span>
        <span id="lowercase">Includes a lowercase letter</span>
        <span id="number">Includes a number</span>
        <span id="symbol">Includes a symbol</span>
    </div>
    <div class="flex flex-col items-center justify-center mb-4">
        <button class="bg-white rounded-full w-full hover:bg-gray-100 text-[#111418] font-bold py-2 px-4 focus:outline-none focus:shadow-outline" type="submit">
            Submit
        </button>
    </div>
    <span class="text-sm items-left text-gray-400">Have an account yet ? <a class="text-sky-300" href="/src/pages/sign-in.php">Sign In</a></span>
</form>

<script>
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const passwordCriteria = document.getElementById('passwordCriteria');
    const passwordCheck = document.getElementById('passwordCheck');

    function validatePassword() {
        const passValue = passwordInput.value;
        const confirmPassValue = confirmPasswordInput.value;
        const criteria = {
            length: passValue.length >= 8,
            uppercase: /[A-Z]/.test(passValue),
            lowercase: /[a-z]/.test(passValue),
            number: /[0-9]/.test(passValue),
            symbol: /[^\w]/.test(passValue)
        };

        document.getElementById('length').style.color = criteria.length ? 'green' : 'red';
        document.getElementById('uppercase').style.color = criteria.uppercase ? 'green' : 'red';
        document.getElementById('lowercase').style.color = criteria.lowercase ? 'green' : 'red';
        document.getElementById('number').style.color = criteria.number ? 'green' : 'red';
        document.getElementById('symbol').style.color = criteria.symbol ? 'green' : 'red';

        if (confirmPassValue.length > 0) {
            if (passValue === confirmPassValue && Object.values(criteria).every(Boolean)) {
                passwordCheck.textContent = '✓ Passwords match';
                passwordCheck.style.color = 'green';
            } else {
                passwordCheck.textContent = '✕ Passwords do not match';
                passwordCheck.style.color = 'red';
            }
        } else {
            passwordCheck.textContent = '';
        }
    }

    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validatePassword);
</script>