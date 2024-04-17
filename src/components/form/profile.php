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

<form action="../../../src/security/profile.php" method="POST" enctype="multipart/form-data" class="flex min-h-screen">
    <!-------------------------- PERSONAL DETAILS --------------------------->
    <div class="px-8 pt-6 pb-8 mb-4 items-center justify-center max-w-3xl" id="personalDetails">
        <!-------------------------- REQUIRED --------------------------->
        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-medium_gray"></span>
            <span class="mx-2 text-sm font-medium text-medium_gray">REQUIRED</span>
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
                <div class="flex items-center">
                    <input type="radio" name="gender" value="Male" id="genderMale" class="mr-2" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Male') ? 'checked' : ''; ?>>
                    <label for="genderMale" class="mr-4 text-white">Male</label>

                    <input type="radio" name="gender" value="Female" id="genderFemale" class="mr-2" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Female') ? 'checked' : ''; ?>>
                    <label for="genderFemale" class="mr-4 text-white">Female</label>

                    <input type="radio" name="gender" value="Other" id="genderOther" class="mr-2" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Other') ? 'checked' : ''; ?>>
                    <label for="genderOther" class="mr-4 text-white">Other</label>
                </div>
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
                    Country of Residence <span class="font-bold text-red-600">*</span>
                </label>
                <select class="border-[#4C5059] border bg-black rounded-md w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline" id="country" name="country">
                    <option value="">Select a country</option>
                    <option value="France" <?php if (isset($_SESSION['form_values']['country']) && $_SESSION['form_values']['country'] === "France") echo "selected"; ?>>France</option>
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
                <div class="flex items-center">
                    <input type="radio" name="looking_for" value="Male" id="lookingForMale" class="mr-2" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Male') ? 'checked' : ''; ?>>
                    <label for="lookingForMale" class="mr-4 text-white">Male</label>

                    <input type="radio" name="looking_for" value="Female" id="lookingForFemale" class="mr-2" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Female') ? 'checked' : ''; ?>>
                    <label for="lookingForFemale" class="mr-4 text-white">Female</label>

                    <input type="radio" name="looking_for" value="Both" id="lookingForBoth" class="mr-2" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Both') ? 'checked' : ''; ?>>
                    <label for="lookingForBoth" class="mr-4 text-white">Everyone</label>
                </div>
            </div>
        </div>
        <!-------------------------- OPTIONAL --------------------------->
        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-medium_gray"></span>
            <span class="mx-2 text-sm font-medium text-medium_gray">OPTIONAL</span>
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
                <label class="block text-sm font-bold mb-2">
                    Smoking Status
                </label>
                <div class="flex items-center mb-2">
                    <input id="smokingYes" type="radio" name="smoking" class="mr-2" value="Yes" <?php echo (isset($_SESSION['form_values']['smoking']) && $_SESSION['form_values']['smoking'] == 'Yes') ? 'checked' : ''; ?>>
                    <label for="smokingYes" class="mr-4 text-white">Yes</label>

                    <input id="smokingNo" type="radio" name="smoking" class="mr-2" value="No" <?php echo (isset($_SESSION['form_values']['smoking']) && $_SESSION['form_values']['smoking'] == 'No') ? 'checked' : ''; ?>>
                    <label for="smokingNo" class="mr-4 text-white">No</label>
                </div>
            </div>
            <!-- HOBBIES -->
            <input type="hidden" id="hiddenHobbiesInput" name="hobbies" value="<?php echo htmlspecialchars($_SESSION['form_values']['hobbies'] ?? '') ?>">
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2">
                    Hobbies
                </label>
                <div class="flex flex-wrap gap-1">
                    <div class="cursor-pointer bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300" data-hobby="Reading">Reading</div>
                    <div class="cursor-pointer bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300" data-hobby="Traveling">Traveling</div>
                </div>
            </div>
            <div class="w-full px-3 mb-4">
                <label class="block text-sm font-bold mb-2" for="about_me">
                    About me
                </label>
                <textarea class="bg-black border border-medium_gray rounded-lg w-full py-2 px-3 leading-tight focus:outline-none focus:border-white" placeholder="Tell us something about you" rows="4" id="about_me" name="about_me"><?php echo htmlspecialchars($_SESSION['form_values']['about_me'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="flex justify-center">
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </div>


    <!-------------------------- PHOTOS SECTION --------------------------->
    <div id="photoUploadForm" class="w-full px-8 pt-6 pb-8 mb-4 hidden">
        <div class="grid grid-cols-3 gap-4">
            <div class="photo-card relative w-[120px] h-[200px] border-2 border-dashed border-gray-300 bg-[#1C1D1D] rounded-lg cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload1').click()">
                <input type="file" id="photo-upload1" class="hidden" accept="image/*" onchange="loadImage(event, 'photo1')">
                <div id="photo1" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                    <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-br from-sky-300 to-fuchsia-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="photo-card relative w-[120px] h-[200px] border-2 border-dashed border-gray-300 bg-[#1C1D1D] rounded-lg cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload1').click()">
                <input type="file" id="photo-upload2" class="hidden" accept="image/*" onchange="loadImage(event, 'photo2')">
                <div id="photo1" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                    <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-br from-sky-300 to-fuchsia-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="photo-card relative w-[120px] h-[200px] border-2 border-dashed border-gray-300 bg-[#1C1D1D] rounded-lg cursor-pointer overflow-visible" onclick="document.getElementById('photo-upload1').click()">
                <input type="file" id="photo-upload3" class="hidden" accept="image/*" onchange="loadImage(event, 'photo3')">
                <div id="photo1" class="photo-placeholder absolute inset-0 flex items-center justify-center">
                    <div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-br from-sky-300 to-fuchsia-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-between mt-4">
            <button type="button" class="p-4 rounded-full border-white border-2 mb-4" onclick="toggleForms()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold p-4 rounded">Submit</button>
        </div>
    </div>
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
        const selectedHobbies = "<?php echo $_SESSION['form_values']['hobbies'] ?? ''; ?>".split(',').map(h => h.trim());

        document.querySelectorAll('.hobby-badge').forEach(badge => {
            if (selectedHobbies.includes(badge.getAttribute('data-hobby'))) {
                badge.classList.add('bg-blue-500', 'text-white', 'border-blue-700');
            }
        });


        function updateFormData() {
            const selectedHobbies = Array.from(document.querySelectorAll('.hobby-badge.bg-blue-500')).map(badge => badge.getAttribute('data-hobby'));

            document.getElementById('hiddenHobbiesInput').value = selectedHobbies.join(', ');
        }

        document.querySelectorAll('.hobby-badge').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.toggle('bg-blue-500');
                this.classList.toggle('text-white');
                this.classList.toggle('border-blue-700');
                updateFormData();
            });
        });
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
            output.innerHTML = `<div class="delete-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-br from-red-500 to-red-800" onclick="event.stopPropagation(); deleteImage('${photoId}');">
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
        output.innerHTML = `<div class="add-icon absolute bottom-[-8px] right-[-8px] border-[1.5px] border-white rounded-full p-[1.5px] bg-gradient-to-br from-sky-300 to-fuchsia-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>`;
    }
</script>