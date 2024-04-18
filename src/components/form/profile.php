<?php session_start(); ?>

<?php if (isset($_SESSION['error_message'])) : ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
        <strong class="font-bold">Error !</strong>
        <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['error_message']); ?></span>
        <button onclick="this.parentElement.remove();" class="absolute top-0 bottom-0 right-0 px-4 py-3">
        </button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

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
                    <li>
                        <input type="radio" id="genderMale" name="gender" value="Male" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Male') ? 'checked' : ''; ?>>
                        <label for="genderMale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Male</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="genderFemale" name="gender" value="Female" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Female') ? 'checked' : ''; ?>>
                        <label for="genderFemale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Female</div>
                            </div>
                        </label>
                    </li>
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
                    <li>
                        <input type="radio" id="lookingForMale" name="looking_for" value="Male" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['looking_for'] == 'Male') ? 'checked' : ''; ?>>
                        <label for="lookingForMale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Male</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="lookingForFemale" name="looking_for" value="Female" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['looking_for'] == 'Female') ? 'checked' : ''; ?>>
                        <label for="lookingForFemale" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Female</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="lookingForBoth" name="looking_for" value="Both" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['looking_for'] == 'Everyone') ? 'checked' : ''; ?>>
                        <label for="lookingForBoth" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Everyone</div>
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
                    <li>
                        <input type="radio" id="smokingYes" name="smoking" value="Yes" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['looking_for'] == 'Male') ? 'checked' : ''; ?>>
                        <label for="smokingYes" class="inline-flex items-center px-6 py-2 text-medium_gray bg-black border-2 border-medium_gray hover:border-white hover:text-white rounded-full cursor-pointer peer-checked:border-white peer-checked:text-transparent peer-checked:bg-clip-text peer-checked:bg-gradient-to-br peer-checked:from-sky_primary peer-checked:to-rose_primary">
                            <div class="flex items-center justify-center w-full">
                                <div class="text-sm font-semibold">Yes</div>
                            </div>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="smokingNo" name="smoking" value="No" class="hidden peer" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['looking_for'] == 'Female') ? 'checked' : ''; ?>>
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
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col items-center justify-center mb-4">
            <button class="bg-white rounded-full w-full hover:bg-gray-300 text-black font-bold py-2 px-4 focus:outline-none" type="submit">
                Submit
            </button>
        </div>
    </section>
    <!-------------------------- MUSIC SECTION --------------------------->
    <section>
        <!-- TODO: -->
    </section>
</form>

<script>
    document.getElementsByName("birth_year")[0].addEventListener('input', function() {
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });
    document.getElementsByName("birth_month")[0].addEventListener('input', function() {
        if (this.value.length > 2) {
            this.value = this.value.slice(0, 2);
        }
    });
    document.getElementsByName("birth_day")[0].addEventListener('input', function() {
        if (this.value.length > 2) {
            this.value = this.value.slice(0, 2);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const selectedHobbies = "<?php echo $_SESSION['form_values']['hobbies'] ?? ''; ?>".split(',').filter(h => h.trim().length > 0);

        const badges = document.querySelectorAll('.hobby-badge');
        badges.forEach(badge => {
            if (selectedHobbies.includes(badge.getAttribute('data-hobby'))) {
                badge.classList.add('bg-sky_primary', 'text-blue-900', 'border-sky_primary');
            }

            badge.addEventListener('click', function() {
                this.classList.toggle('bg-sky_primary');
                this.classList.toggle('text-blue-900');
                this.classList.toggle('border-sky_primary');
                updateFormData();
            });
        });

        function updateFormData() {
            const selectedHobbies = Array.from(document.querySelectorAll('.hobby-badge.bg-blue-500'))
                .map(badge => badge.getAttribute('data-hobby'));
            document.getElementById('hiddenHobbiesInput').value = selectedHobbies.join(', ');
        }
    });

    function toggleForms() {
        var personalDetails = document.getElementById('personalDetails');
        var photoUploadForm = document.getElementById('photoUploadForm');

        if (personalDetails.style.display === 'none') {
            personalDetails.style.display = 'block';
            photoUploadForm.style.display = 'none';
        } else {
            personalDetails.style.display = 'none';
            photoUploadForm.style.display = 'block';
        }
        window.scrollTo(0, 0);
    }

    document.getElementById('photoCard1').addEventListener('click', function() {
        document.getElementById('photo-upload1').click();
    });

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