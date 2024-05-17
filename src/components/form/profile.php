<?php session_start(); ?>

<!-- Display error message if available -->
<?php if (isset($_SESSION['error_message'])) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['error_message']); ?></span>
        <button onclick="this.parentElement.remove();" class="absolute top-0 bottom-0 right-0 px-4 py-3"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Form to complete the profile -->
<form action="/src/security/profileCompletion.php" method="POST" enctype="multipart/form-data" class="flex min-h-screen">

    <!-------------------------- PERSONAL DETAILS SECTION --------------------------->
    <section class="px-8 pt-6 pb-8 mb-4 items-center justify-center max-w-3xl" id="personalDetails">
        <!-------------------------- REQUIRED --------------------------->
        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-medium_gray"></span>
            <span class="mx-2 text-xs uppercase font-semibold text-medium_gray">REQUIRED</span>
            <span class="flex-grow border-t border-medium_gray"></span>
        </div>
        <div class="flex flex-wrap -mx-3 mb-4">
            <!-- FIRST NAME -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="first_name">
                    First Name <span class="font-bold text-red-600">*</span>
                </label>
                <input class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white" id="first_name" name="first_name" type="text" placeholder="Jean" value="<?php echo htmlspecialchars($_SESSION['form_values']['first_name'] ?? '') ?>">
            </div>
            <!-- LAST NAME -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="last_name">
                    Last Name <span class="font-bold text-red-600">*</span>
                </label>
                <input class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white" id="last_name" name="last_name" type="text" placeholder="Dupont" value="<?php echo htmlspecialchars($_SESSION['form_values']['last_name'] ?? '') ?>">
            </div>
            <!-- GENDER -->
            <div class="w-full px-3 mb-4">
                <span class="block text-sm font-bold mb-2">
                    Gender <span class="font-bold text-red-600">*</span>
                </span>
                <ul class="grid gap-4 grid-cols-3 md:w-1/2">
                    <!-- Male -->
                    <li>
                        <input type="radio" id="genderMale" name="gender" value="Male" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Male') ? 'checked' : ''; ?>>
                        <label for="genderMale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Male</div>
                            </div>
                        </label>
                    </li>
                    <!-- Female -->
                    <li>
                        <input type="radio" id="genderFemale" name="gender" value="Female" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Female') ? 'checked' : ''; ?>>
                        <label for="genderFemale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Female</div>
                            </div>
                        </label>
                    </li>
                    <!-- Other -->
                    <li>
                        <input type="radio" id="genderOther" name="gender" value="Other" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Other') ? 'checked' : ''; ?>>
                        <label for="genderOther" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Other</div>
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
            <!-- DATE OF BIRTH -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="date_of_birth">
                    Date of Birth <span class="font-bold text-red-600">*</span>
                </label>
                <div class="flex gap-4">
                    <input class="bg-black border border-medium_gray rounded-lg py-2 px-3 leading-tight focus:outline-none focus:border-white w-32" type="number" placeholder="YYYY" name="birth_year" value="<?php echo htmlspecialchars($_SESSION['form_values']['birth_year'] ?? '') ?>">
                    <input class="bg-black border border-medium_gray rounded-lg py-2 px-3 leading-tight focus:outline-none focus:border-white w-24" type="number" placeholder="MM" name="birth_month" max="12" min="1" value="<?php echo htmlspecialchars($_SESSION['form_values']['birth_month'] ?? '') ?>">
                    <input class="bg-black border border-medium_gray rounded-lg py-2 px-3 leading-tight focus:outline-none focus:border-white w-24" type="number" placeholder="DD" name="birth_day" max="31" min="1" value="<?php echo htmlspecialchars($_SESSION['form_values']['birth_day'] ?? '') ?>">
                </div>
            </div>
            <!-- COUNTRY -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="country">
                    Select a country <span class="font-bold text-red-600">*</span>
                </label>
                <select class="border-medium_gray border bg-black rounded-md w-full py-2 px-3 text-white leading-tight focus:outline-none focus:border-white" id="country" name="country">
                    <option value="" <?php echo (!isset($_SESSION['form_values']['country']) || $_SESSION['form_values']['country'] === "") ? "selected" : ""; ?>>Choose a country</option>
                    <option value="US" <?php echo (isset($_SESSION['form_values']['country']) && $_SESSION['form_values']['country'] === "US") ? "selected" : ""; ?>>United States</option>
                    <option value="CA" <?php echo (isset($_SESSION['form_values']['country']) && $_SESSION['form_values']['country'] === "CA") ? "selected" : ""; ?>>Canada</option>
                    <option value="FR" <?php echo (isset($_SESSION['form_values']['country']) && $_SESSION['form_values']['country'] === "FR") ? "selected" : ""; ?>>France</option>
                    <option value="DE" <?php echo (isset($_SESSION['form_values']['country']) && $_SESSION['form_values']['country'] === "DE") ? "selected" : ""; ?>>Germany</option>
                </select>
            </div>
            <!-- CITY -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="city">
                    City <span class="font-bold text-red-600">*</span>
                </label>
                <input class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white" type="text" placeholder="London" id="city" name="city" value="<?php echo htmlspecialchars($_SESSION['form_values']['city'] ?? '') ?>">
            </div>
            <!-- LOOKING FOR -->
            <div class="w-full px-3 mb-4">
                <span class="block text-sm font-bold mb-2">
                    Looking for <span class="font-bold text-red-600">*</span>
                </span>
                <ul class="grid gap-4 grid-cols-3 md:w-1/2">
                    <!-- Male -->
                    <li>
                        <input type="radio" id="lookingForMale" name="looking_for" value="Male" class="hidden peer" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Male') ? 'checked' : ''; ?>>
                        <label for="lookingForMale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Male</div>
                            </div>
                        </label>
                    </li>
                    <!-- Female -->
                    <li>
                        <input type="radio" id="lookingForFemale" name="looking_for" value="Female" class="hidden peer" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Female') ? 'checked' : ''; ?>>
                        <label for="lookingForFemale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Female</div>
                            </div>
                        </label>
                    </li>
                    <!-- Both -->
                    <li>
                        <input type="radio" id="lookingForBoth" name="looking_for" value="Both" class="hidden peer" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Both') ? 'checked' : ''; ?>>
                        <label for="lookingForBoth" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Both</div>
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <!-------------------------- OPTIONAL --------------------------->
        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-medium_gray"></span>
            <span class="mx-2 text-xs uppercase font-semibold text-medium_gray">OPTIONAL</span>
            <span class="flex-grow border-t border-medium_gray"></span>
        </div>
        <div class="flex flex-wrap -mx-3 mb-4">
            <!-- OCCUPATION -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="occupation">
                    Occupation
                </label>
                <input class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white" type="text" placeholder="Engineer" id="occupation" name="occupation" value="<?php echo htmlspecialchars($_SESSION['form_values']['occupation'] ?? '') ?>">
            </div>
            <!-- SMOKING STATUS -->
            <div class="w-full px-3 mb-4">
                <span class="block text-sm font-bold mb-2">
                    Smoking Status
                </span>
                <ul class="grid gap-4 grid-cols-3 md:w-1/2">
                    <!-- Yes -->
                    <li>
                        <input type="radio" id="smokingYes" name="smoking" value="Yes" class="hidden peer" <?php echo (isset($_SESSION['form_values']['smoking']) && $_SESSION['form_values']['smoking'] == 'Yes') ? 'checked' : ''; ?>>
                        <label for="smokingYes" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Yes</div>
                            </div>
                        </label>
                    </li>
                    <!-- No -->
                    <li>
                        <input type="radio" id="smokingNo" name="smoking" value="No" class="hidden peer" <?php echo (isset($_SESSION['form_values']['smoking']) && $_SESSION['form_values']['smoking'] == 'No') ? 'checked' : ''; ?>>
                        <label for="smokingNo" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">No</div>
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
            <!-- HOBBIES -->
            <input type="hidden" id="hiddenHobbiesInput" name="hobbies" value="<?php echo htmlspecialchars($_SESSION['form_values']['hobbies'] ?? '') ?>">
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2">Hobbies</label>
                <div class="flex flex-wrap gap-1">
                    <div class="cursor-pointer hobby-badge bg-gray-700 text-gray-300 text-xs font-semibold me-2 px-2.5 py-0.5 rounded-full" data-hobby="Reading">Reading</div>
                    <div class="cursor-pointer hobby-badge bg-gray-700 text-gray-300 text-xs font-semibold me-2 px-2.5 py-0.5 rounded-full" data-hobby="Traveling">Traveling</div>
                </div>
            </div>
            <!-- ABOUT ME -->
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="about_me">
                    About me
                </label>
                <textarea class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white" placeholder="Tell us something about you" rows="4" id="about_me" name="about_me"><?php echo htmlspecialchars($_SESSION['form_values']['about_me'] ?? '') ?></textarea>
            </div>
        </div>
        <!-- NEXT STEP BUTTON -->
        <div class="flex justify-center">
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </section>

    <!-------------------------- PHOTOS SECTION --------------------------->
    <section id="photoUploadForm" class="hidden">
        <div class="w-full mx-auto flex flex-col items-center justify-center pt-6 pb-8 mb-24 ">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 justify-center items-center">
                <!-- Photo Card 1 -->
                <div class="photo-card relative w-[165px] h-[240px] border-2 border-dashed border-medium_gray bg-black rounded-xl cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload1').click()">
                    <input type="file" name="photo1" id="photo-upload1" class="hidden" accept="image/*" onchange="loadImage(event, 'photo1')">
                    <div id="photo1" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                        <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-b from-sky_primary to-rose_primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Photo Card 2 -->
                <div class="photo-card relative w-[165px] h-[240px] border-2 border-dashed border-medium_gray bg-black rounded-xl cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload2').click()">
                    <input type="file" name="photo2" id="photo-upload2" class="hidden" accept="image/*" onchange="loadImage(event, 'photo2')">
                    <div id="photo2" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                        <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-b from-sky_primary to-rose_primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Photo Card 3 -->
                <div class="photo-card relative w-[165px] h-[240px] border-2 border-dashed border-medium_gray bg-black rounded-xl cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload3').click()">
                    <input type="file" name="photo3" id="photo-upload3" class="hidden" accept="image/*" onchange="loadImage(event, 'photo3')">
                    <div id="photo3" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                        <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-b from-sky_primary to-rose_primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Photo Card 4 -->
                <div class="photo-card relative w-[165px] h-[240px] border-2 border-dashed border-medium_gray bg-black rounded-xl cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload4').click()">
                    <input type="file" name="photo4" id="photo-upload4" class="hidden" accept="image/*" onchange="loadImage(event, 'photo4')">
                    <div id="photo4" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                        <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-b from-sky_primary to-rose_primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-medium_gray font-semibold text-base text-center w-full">Upload 2 photos to start, 4 if you want your profile to be liked as much as possible</p>
        <div class="flex flex-row gap-6 md:gap-24 justify-center mt-24 mb-24">
            <!-- Button to go back to the previous section -->
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <!-- Button to proceed to the next section -->
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms2()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </section>

    <!-------------------------- MUSIC SECTION --------------------------->
    <section id="MusicForm" class="hidden">
        <div class="container mx-auto px-4 my-8">
            <div id="musicGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10"></div>
            <input type="hidden" id="hiddenMusicInput" name="selected_music" value="<?php echo htmlspecialchars($_SESSION['form_values']['selected_music'] ?? '') ?>">
        </div>
        <p class="text-medium_gray font-semibold text-base text-center w-full">Select at least one music genre to start</p>
        <div class="flex flex-row gap-6 md:gap-24 justify-center mt-24 mb-24">
            <!-- Button to go back to the previous section -->
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms2()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <!-- Submit button -->
            <button type="submit" class="p-4 rounded-full border-white border-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </section>

</form>

<script>
    // List of music genres with their corresponding image URLs
    const musicList = [{
            title: "Pop",
            imageUrl: "../../../assets/music/pop.png"
        },
        {
            title: "Rock",
            imageUrl: "../../../assets/music/rock.png"
        },
        {
            title: "Rap",
            imageUrl: "../../../assets/music/rap.png"
        },
        {
            title: "Jazz",
            imageUrl: "../../../assets/music/jazz.png"
        },
        {
            title: "Classical",
            imageUrl: "../../../assets/music/classical.png"
        },
        {
            title: "Metal",
            imageUrl: "../../../assets/music/metal.png"
        },
        {
            title: "Electronic",
            imageUrl: "../../../assets/music/electronic.png"
        },
        {
            title: "Funk",
            imageUrl: "../../../assets/music/funk.png"
        },
    ];

    // Retrieve selected music titles from session and split them into an array
    const selectedMusicTitles = "<?php echo $_SESSION['form_values']['selected_music'] ?? ''; ?>".split(',').map(m => m.trim());

    class MusicCard {
        // Constructor to initialize the MusicCard class with container ID, music list, and selected titles
        constructor(containerId, musics, selectedTitles) {
            this.container = document.getElementById(containerId);
            this.musics = musics;
            this.selectedTitles = selectedTitles;
        }

        // Initialize the music card by rendering and adding event listeners
        init() {
            this.renderMusicCards();
            this.addEventListeners();
        }

        // Render the music cards in the container
        renderMusicCards() {
            this.musics.forEach((music) => {
                const isSelected = this.selectedTitles.includes(music.title);
                const musicDiv = document.createElement('div');
                musicDiv.className = `music-card mb-4 rounded-lg shadow-lg cursor-pointer flex flex-col items-center ${isSelected ? 'selected' : ''}`;
                musicDiv.innerHTML = `
                <div class="relative music-badge" data-music-title="${music.title}">
                    <img src="${music.imageUrl}" alt="${music.title}" class="rounded-lg w-48 h-48 object-cover">
                    <div class="overlay ${isSelected ? '' : 'hidden'} absolute inset-0 bg-black bg-opacity-50 flex border-2 border-white justify-center items-center rounded-lg">
                        <span class="text-white text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                            </svg>
                        </span>
                    </div>
                </div>
            `;
                this.container.appendChild(musicDiv);
            });
        }

        // Add click event listeners to each music card for selection
        addEventListeners() {
            document.querySelectorAll('.music-card .music-badge').forEach(card => {
                card.addEventListener('click', function(event) {
                    if (event.target.tagName !== 'BUTTON') {
                        this.querySelector('.overlay').classList.toggle('hidden');
                        updateSelectedMusic();
                    }
                });
            });
        }
    }

    // Instantiate and initialize the music card selection
    const musicCard = new MusicCard('musicGrid', musicList, selectedMusicTitles);
    musicCard.init();

    document.addEventListener('DOMContentLoaded', function() {
        updateSelectedMusic();
    });

    // Update the hidden input field with the selected music genres
    function updateSelectedMusic() {
        const selectedMusics = Array.from(document.querySelectorAll('.music-card'))
            .filter(card => !card.querySelector('.overlay').classList.contains('hidden'))
            .map(card => card.querySelector('.music-badge').getAttribute('data-music-title'));

        document.getElementById('hiddenMusicInput').value = selectedMusics.join(', ');
    }

    // Toggle between the photo upload form and the music selection form
    function toggleForms2() {
        const musicForm = document.getElementById('MusicForm');
        musicForm.classList.toggle('hidden');
    }

    // Restrict birth year input to 4 digits
    document.getElementsByName("birth_year")[0].addEventListener('input', function() {
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });

    // Restrict birth month input to 2 digits
    document.getElementsByName("birth_month")[0].addEventListener('input', function() {
        if (this.value.length > 2) {
            this.value = this.value.slice(0, 2);
        }
    });

    // Restrict birth day input to 2 digits
    document.getElementsByName("birth_day")[0].addEventListener('input', function() {
        if (this.value.length > 2) {
            this.value = this.value.slice(0, 2);
        }
    });

    // Handle hobbies selection and update hidden input field
    document.addEventListener('DOMContentLoaded', function() {
        const selectedHobbies = "<?php echo htmlspecialchars($_SESSION['form_values']['hobbies'] ?? ''); ?>".split(',').filter(h => h.trim().length > 0);

        const badges = document.querySelectorAll('.hobby-badge');
        badges.forEach(badge => {
            if (selectedHobbies.includes(badge.getAttribute('data-hobby'))) {
                badge.classList.add('bg-blue-500', 'text-white');
            }

            badge.addEventListener('click', function() {
                this.classList.toggle('bg-blue-500');
                this.classList.toggle('text-white');
                updateFormData();
            });
        });

        function updateFormData() {
            const selectedHobbies = Array.from(document.querySelectorAll('.hobby-badge.bg-blue-500'))
                .map(badge => badge.getAttribute('data-hobby'));
            document.getElementById('hiddenHobbiesInput').value = selectedHobbies.join(', ');
        }
    });

    // Toggle between personal details and photo upload form
    function toggleForms() {
        const personalDetails = document.getElementById('personalDetails');
        const photoUploadForm = document.getElementById('photoUploadForm');

        if (personalDetails.style.display === 'none') {
            personalDetails.style.display = 'block';
            photoUploadForm.style.display = 'none';
        } else {
            personalDetails.style.display = 'none';
            photoUploadForm.style.display = 'block';
        }
        window.scrollTo(0, 0);
    }

    // Toggle between photo upload form and music selection form
    function toggleForms2() {
        const personalDetails = document.getElementById('photoUploadForm');
        const MusicForm = document.getElementById('MusicForm');

        if (personalDetails.style.display === 'none') {
            personalDetails.style.display = 'block';
            MusicForm.style.display = 'none';
        } else {
            personalDetails.style.display = 'none';
            MusicForm.style.display = 'block';
        }
        window.scrollTo(0, 0);
    }

    // Event listener for clicking on photo card to open file input
    document.getElementById('photoCard1').addEventListener('click', function() {
        document.getElementById('photo-upload1').click();
    });

    // Load the selected image and display it in the photo card
    function loadImage(event, photoId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(photoId);
            output.style.backgroundImage = 'url(' + reader.result + ')';
            output.style.backgroundSize = 'cover';
            output.style.backgroundPosition = 'center';
            output.style.backgroundRepeat = 'no-repeat';
            output.style.borderRadius = '8px';
            output.innerHTML = `<div class="delete-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-b from-red_primary to-rose_secondary" onclick="event.stopPropagation(); deleteImage('${photoId}');">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </div>`;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Delete the selected image from the photo card
    function deleteImage(photoId) {
        var output = document.getElementById(photoId);
        output.style.backgroundImage = '';
        output.innerHTML = `<div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-b from-sky_primary to-rose_primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>`;
    }
</script>