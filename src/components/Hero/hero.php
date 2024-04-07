<section class="container mx-auto mt-4">
    <div class="flex justify-center items-center gap-4">
        <span>Harmony : </span>
        <button id="SignUpButton" class="bg-fuchsia-300 rounded-full text-fuchsia-900 text-base font-semibold py-3 px-6">Sign Up</button>
    </div>
    <div id="SignUpModal" class="hidden flex justify-center mb-24 mt-24 items-center">
        <div class="border border-black p-5 rounded-lg relative">
            <div id="CloseButton" class="absolute top-0 right-0 p-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
            <h2 class="text-lg font-bold mt-4 mb-4">Sign Up to Harmony</h2>
            <?php require_once 'src/components/Form/sign-up.php'; ?>
        </div>
    </div>

</section>
<script src="/src/components/Hero/hero.js"></script>