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

<form action="../../../src/security/update-profile.php" method="POST" enctype="multipart/form-data" class="flex min-h-screen">
    <div class="w-1/2 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-gray-300"></span>
            <span class="mx-2 text-sm text-gray-600"></span>
            <span class="flex-grow border-t border-gray-300"></span>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="username">
                    Username
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="username" name="username" type="text" placeholder="Jean" value="<?php echo htmlspecialchars($_SESSION['username'] ?? '') ?>">
            </div>
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="first_name">
                    First Name
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="first_name" name="first_name" type="text" placeholder="Jean" value="<?php echo htmlspecialchars($_SESSION['form_values']['first_name'] ?? '') ?>">
            </div>
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="last_name">
                    Last Name
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="last_name" name="last_name" type="text" placeholder="Dupont" value="<?php echo htmlspecialchars($_SESSION['form_values']['last_name'] ?? '') ?>">
            </div>
        </div>
        <div class="mb-4">
            <span class="text-gray-700 text-sm font-bold mb-2">
                Gender
            </span>
            <div class="flex items-center">
                <input type="radio" name="gender" value="Male" id="genderMale" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Male') ? 'checked' : ''; ?>>
                <label for="genderMale" class="mr-4">Male</label>

                <input type="radio" name="gender" value="Female" id="genderFemale" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Female') ? 'checked' : ''; ?>>
                <label for="genderFemale" class="mr-4">Female</label>

                <input type="radio" name="gender" value="Other" id="genderOther" <?php echo (isset($_SESSION['form_values']['gender']) && $_SESSION['form_values']['gender'] == 'Other') ? 'checked' : ''; ?>>
                <label for="genderOther">Other</label>
            </div>

        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">
                Date of Birth
            </label>
            <div class="flex">
                <input class="shadow appearance-none border rounded py-2 px-1 sm:px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-16 w-auto bg-blue-100" type="number" placeholder="YYYY" name="birth_year" value="<?php echo htmlspecialchars($_SESSION['form_values']['birth_year'] ?? '') ?>">
                <input class="shadow appearance-none border rounded py-2 px-1 sm:px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mx-2 w-8 w-auto bg-green-100" type="number" placeholder="MM" name="birth_month" max="12" min="1" value="<?php echo htmlspecialchars($_SESSION['form_values']['birth_month'] ?? '') ?>">
                <input class="shadow appearance-none border rounded py-2 px-1 sm:px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-8 w-auto bg-yellow-100" type="number" placeholder="DD" name="birth_day" max="31" min="1" value="<?php echo htmlspecialchars($_SESSION['form_values']['birth_day'] ?? '') ?>">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
                Country of Residence
            </label>
            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" name="country">
                <option value="">Select a country</option>
                <option value="France" <?php if (isset($_SESSION['form_values']['country']) && $_SESSION['form_values']['country'] === "France") echo "selected"; ?>>France</option>
            </select>

        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                City
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="London" id="city" name="city" value="<?php echo htmlspecialchars($_SESSION['form_values']['city'] ?? '') ?>">
        </div>
        <div class="mb-4">
            <span class="text-gray-700 text-sm font-bold mb-2">
                Looking for
            </span>
            <div class="flex items-center">
                <input type="radio" name="looking_for" value="Male" id="lookingForMale" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Male') ? 'checked' : ''; ?>>
                <label for="lookingForMale" class="mr-4">Male</label>

                <input type="radio" name="looking_for" value="Female" id="lookingForFemale" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Female') ? 'checked' : ''; ?>>
                <label for="lookingForFemale">Female</label>

                <input type="radio" name="looking_for" value="Both" id="lookingForBoth" <?php echo (isset($_SESSION['form_values']['looking_for']) && $_SESSION['form_values']['looking_for'] == 'Both') ? 'checked' : ''; ?>>
                <label for="lookingForBoth">Both</label>
            </div>
        </div>
        <div class="mb-4">
            <div id="musicList" class="grid grid-cols-3 gap-4">
            </div>
        </div>
        <input type="hidden" id="hiddenSelectedMusic" name="selected_music" value="<?php echo htmlspecialchars($_SESSION['form_values']['selected_music'] ?? '') ?>">

        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-gray-300"></span>
            <span class="mx-2 text-sm text-gray-600">Optional</span>
            <span class="flex-grow border-t border-gray-300"></span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="occupation">
                Occupation
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Engineer" id="occupation" name="occupation" value="<?php echo htmlspecialchars($_SESSION['form_values']['occupation'] ?? '') ?>">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Smoking Status
            </label>
            <div class="flex items-center mb-2">
                <input id="smokingYes" type="radio" name="smoking" class="mr-2" value="Yes" <?php echo (isset($_SESSION['form_values']['smoking']) && $_SESSION['form_values']['smoking'] == 'Yes') ? 'checked' : ''; ?>>
                <label for="smokingYes" class="mr-4">Yes</label>

                <input id="smokingNo" type="radio" name="smoking" class="mr-2" value="No" <?php echo (isset($_SESSION['form_values']['smoking']) && $_SESSION['form_values']['smoking'] == 'No') ? 'checked' : ''; ?>>
                <label for="smokingNo">No</label>
            </div>
        </div>
        <input type="hidden" id="hiddenHobbiesInput" name="hobbies" value="<?php echo htmlspecialchars($_SESSION['form_values']['hobbies'] ?? '') ?>">
        <input type="hidden" id="hiddenInterestsInput" name="interests" value="<?php echo htmlspecialchars($_SESSION['form_values']['interests'] ?? '') ?>">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Hobbies</label>
            <div class="flex flex-wrap gap-2">
                <div class="hobby-badge border border-blue-500 hover:bg-blue-500 hover:text-white text-blue-500 py-1 px-3 rounded cursor-pointer" data-hobby="Reading">Reading</div>
                <div class="hobby-badge border border-blue-500 hover:bg-blue-500 hover:text-white text-blue-500 py-1 px-3 rounded cursor-pointer" data-hobby="Traveling">Traveling</div>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Interests</label>
            <div class="flex flex-wrap gap-2">
                <div class="interest-badge border border-green-500 hover:bg-green-500 hover:text-white text-green-500 py-1 px-3 rounded cursor-pointer" data-interest="Technology">Technology</div>
                <div class="interest-badge border border-green-500 hover:bg-green-500 hover:text-white text-green-500 py-1 px-3 rounded cursor-pointer" data-interest="Music">Music</div>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="profile_headline">
                Profile Headline
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="" id="profile_headline" name="profile_headline" value="<?php echo htmlspecialchars($_SESSION['form_values']['profile_headline'] ?? '') ?>">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="favorite_quote">
                Favorite Quote
            </label>
            <input list="quotes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Choose or type your favorite quote" id="favorite_quote" name="favorite_quote" value="<?php echo htmlspecialchars($_SESSION['form_values']['favorite_quote'] ?? '') ?>">
            <datalist id="quotes">
                <option value="Quote1">
                <option value="Quote2">
                <option value="Quote3">
            </datalist>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="bio">
                Bio
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="" id="bio" name="bio" value="<?php echo htmlspecialchars($_SESSION['form_values']['bio'] ?? '') ?>">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="about_me">
                About me
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tell us something about you" rows="4" id="about_me" name="about_me"><?php echo htmlspecialchars($_SESSION['form_values']['about_me'] ?? '') ?></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="ideal_match_description">
                Ideal Match Description
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Describe your ideal match" rows="4" id="ideal_match_description" name="ideal_match_description"><?php echo htmlspecialchars($_SESSION['form_values']['ideal_match_description'] ?? '') ?></textarea>
        </div>

    </div>
    <div class="w-1/2 bg-gray-100 p-4">
        <!-- <div class="w-1/2 bg-gray-100 p-4">
            <div class="mb-4 text-lg font-semibold text-center">Upload Photos</div>
            <div class="grid grid-cols-2 gap-4">
                <input type="file" name="photo1" id="photo-upload1" class="bg-white p-6 shadow-md rounded flex items-center justify-center cursor-pointer">
                <input type="file" name="photo2" id="photo-upload2" class="bg-white p-6 shadow-md rounded flex items-center justify-center cursor-pointer">
                <input type="file" name="photo3" id="photo-upload3" class="bg-white p-6 shadow-md rounded flex items-center justify-center cursor-pointer">
                <input type="file" name="photo4" id="photo-upload4" class="bg-white p-6 shadow-md rounded flex items-center justify-center cursor-pointer">
            </div>
            <div class="flex items-center justify-center mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
            </div>
        </div> -->

        <div id="musicGrid" class="container mx-auto px-4 my-8">
            <h2 class="text-3xl font-bold mb-4 text-center">Select Music</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            </div>
        </div>
        <input type="hidden" id="hiddenMusicInput" name="selected_music" value="<?php echo htmlspecialchars($_SESSION['form_values']['selected_music'] ?? '') ?>">
        <div class="flex items-center justify-center mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </div>
    </div>

</form>

<script>
    const musicList = [{
            title: "The Life of Pablo",
            imageUrl: "../../../assets/music/rap/the_life_of_pablo.png",
            audioUrl: "../../../assets/music/rap/FML.mp3"
        },
        {
            title: "Nakamura",
            imageUrl: "../../../assets/music/pop/nakamura.png",
            audioUrl: "../../../assets/music/pop/Sucette.mp3"
        }
    ];

    const selectedMusicTitles = "<?php echo $_SESSION['form_values']['selected_music'] ?? ''; ?>".split(',').map(m => m.trim());

    class MusicCard {
        constructor(containerId, musics, selectedTitles) {
            this.container = document.getElementById(containerId);
            this.musics = musics;
            this.selectedTitles = selectedTitles;
        }

        init() {
            this.renderMusicCards();
            this.addEventListeners();
        }

        renderMusicCards() {
            this.musics.forEach((music, index) => {
                const isSelected = this.selectedTitles.includes(music.title);
                const musicDiv = document.createElement('div');
                musicDiv.className = `music-card p-4 bg-white rounded-lg shadow-lg cursor-pointer flex flex-col items-center ${isSelected ? 'selected' : ''}`;
                musicDiv.innerHTML = `
                    <div class="relative music-badge" data-music-title="${music.title}">
                        <img src="${music.imageUrl}" alt="${music.title}" class="rounded-lg w-48 h-48 object-cover">
                        <div class="overlay ${isSelected ? '' : 'hidden'} absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center rounded-lg">
                            <span class="text-white text-2xl">✓</span>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="button" onclick="playAudio('audio${index}', event)" class="text-blue-500">Play</button>
                        <button type="button" onclick="pauseAudio('audio${index}', event)" class="text-red-500">Pause</button>
                    </div>
                    <audio id="audio${index}" class="hidden" src="${music.audioUrl}"></audio>
                `;
                this.container.appendChild(musicDiv);
            });
        }

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

    const musicCard = new MusicCard('musicGrid', musicList, selectedMusicTitles);
    musicCard.init();

    document.addEventListener('DOMContentLoaded', function() {
        updateSelectedMusic();
    });

    function updateSelectedMusic() {
        const selectedMusics = Array.from(document.querySelectorAll('.music-card'))
            .filter(card => !card.querySelector('.overlay').classList.contains('hidden'))
            .map(card => card.querySelector('.music-badge').getAttribute('data-music-title'));

        document.getElementById('hiddenMusicInput').value = selectedMusics.join(', ');
    }

    function playAudio(audioId, event) {
        event.stopPropagation();
        const audio = document.getElementById(audioId);
        audio.play();
    }

    function pauseAudio(audioId, event) {
        event.stopPropagation();
        const audio = document.getElementById(audioId);
        audio.pause();
    }

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
        const selectedInterests = "<?php echo $_SESSION['form_values']['interests'] ?? ''; ?>".split(',').map(i => i.trim());

        document.querySelectorAll('.hobby-badge').forEach(badge => {
            if (selectedHobbies.includes(badge.getAttribute('data-hobby'))) {
                badge.classList.add('bg-blue-500', 'text-white', 'border-blue-700');
            }
        });

        document.querySelectorAll('.interest-badge').forEach(badge => {
            if (selectedInterests.includes(badge.getAttribute('data-interest'))) {
                badge.classList.add('bg-green-500', 'text-white', 'border-green-700');
            }
        });

        document.querySelectorAll('.hobby-badge, .interest-badge').forEach(item => {
            item.addEventListener('click', function() {
                this.classList.toggle('bg-blue-500');
                this.classList.toggle('text-white');
                this.classList.toggle('border-blue-700');
                updateFormData();
            });
        });

        function updateFormData() {
            const selectedHobbies = Array.from(document.querySelectorAll('.hobby-badge.bg-blue-500')).map(badge => badge.getAttribute('data-hobby'));
            const selectedInterests = Array.from(document.querySelectorAll('.interest-badge.bg-green-500')).map(badge => badge.getAttribute('data-interest'));

            document.getElementById('hiddenHobbiesInput').value = selectedHobbies.join(', ');
            document.getElementById('hiddenInterestsInput').value = selectedInterests.join(', ');
        }
    });
</script>