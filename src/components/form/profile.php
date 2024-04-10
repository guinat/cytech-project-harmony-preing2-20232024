<form action="../../../src/security/profile.php" method="POST" enctype="multipart/form-data" class="flex min-h-screen">
    <div class="w-1/2 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-gray-300"></span>
            <span class="mx-2 text-sm text-gray-600">Required</span>
            <span class="flex-grow border-t border-gray-300"></span>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="first_name">
                    First Name
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="first_name" name="first_name" type="text" placeholder="Jean">
            </div>
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="last_name">
                    Last Name
                </label>
                <input class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="last_name" name="last_name" type="text" placeholder="Dupont">
            </div>
        </div>
        <div class="mb-4">
            <span class="text-gray-700 text-sm font-bold mb-2">
                Gender
            </span>
            <div class="flex items-center">
                <input type="radio" name="gender" value="Male" id="genderMale">
                <label for="genderMale" class="mr-4">Male</label>

                <input type="radio" name="gender" value="Female" id="genderFemale">
                <label for="genderFemale" class="mr-4">Female</label>

                <input type="radio" name="gender" value="Other" id="genderOther">
                <label for="genderOther">Other</label>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">
                Date of Birth
            </label>
            <div class="flex">
                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="DD" name="birth_day" max="31" min="1" required>
                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mx-2" type="number" placeholder="MM" name="birth_month" max="12" min="1" required>
                <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="YYYY" name="birth_year" required>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
                Country of Residence
            </label>
            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" name="country">
                <option value="">Select a country</option>
                <option value="France">France</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                City
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="London" id="city" name="city">
        </div>
        <div class="mb-4">
            <span class="text-gray-700 text-sm font-bold mb-2">
                Looking for
            </span>
            <div class="flex items-center">
                <input type="radio" name="looking_for" value="Male" id="lookingForMale">
                <label for="lookingForMale" class="mr-4">Male</label>

                <input type="radio" name="looking_for" value="Female" id="lookingForFemale">
                <label for="lookingForFemale">Female</label>
            </div>
        </div>
        <div class="mb-4">
            <div id="musicList" class="grid grid-cols-3 gap-4">
            </div>
        </div>
        <input type="hidden" id="hiddenSelectedMusic" name="selected_music" value="">

        <div class="flex items-center justify-center mb-4">
            <span class="flex-grow border-t border-gray-300"></span>
            <span class="mx-2 text-sm text-gray-600">Optional</span>
            <span class="flex-grow border-t border-gray-300"></span>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="occupation">
                Occupation
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Engineer" id="occupation" name="occupation">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Smoking Status
            </label>
            <div class="flex items-center mb-2">
                <input id="smokingYes" type="radio" name="smoking" class="mr-2" value="Yes">
                <label for="smokingYes" class="mr-4">Yes</label>

                <input id="smokingNo" type="radio" name="smoking" class="mr-2" value="No">
                <label for="smokingNo">No</label>
            </div>
        </div>
        <input type="hidden" id="hiddenHobbiesInput" name="hobbies">
        <input type="hidden" id="hiddenInterestsInput" name="interests">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Hobbies
            </label>
            <div class="flex flex-wrap gap-2">
                <div class="hobby-badge border border-blue-500 hover:bg-blue-500 hover:text-white text-blue-500 py-1 px-3 rounded cursor-pointer" data-hobby="Reading">Reading</div>
                <div class="hobby-badge border border-blue-500 hover:bg-blue-500 hover:text-white text-blue-500 py-1 px-3 rounded cursor-pointer" data-hobby="Traveling">Traveling</div>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Interests
            </label>
            <div class="flex flex-wrap gap-2">
                <div class="interest-badge border border-green-500 hover:bg-green-500 hover:text-white text-green-500 py-1 px-3 rounded cursor-pointer" data-interest="Technology">Technology</div>
                <div class="interest-badge border border-green-500 hover:bg-green-500 hover:text-white text-green-500 py-1 px-3 rounded cursor-pointer" data-interest="Music">Music</div>
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="profile_headline">
                Profile Headline
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="" id="profile_headline" name="profile_headline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="favorite_quote">
                Favorite Quote
            </label>
            <input list="quotes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Choose or type your favorite quote" id="favorite_quote" name="favorite_quote">
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
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="" id="bio" name="bio">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="about_me">
                About me
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tell us something about you" rows="4" id="about_me" name="about_me"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="ideal_match_description">
                Ideal Match Description
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Describe your ideal match" rows="4" id="ideal_match_description" name="ideal_match_description"></textarea>
        </div>
    </div>
    <div class="w-1/2 bg-gray-100 p-4">
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
    </div>
</form>

<script>
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
        const selectedInterests = Array.from(document.querySelectorAll('.interest-badge.bg-blue-500')).map(badge => badge.getAttribute('data-interest'));

        document.getElementById('hiddenHobbiesInput').value = selectedHobbies.join(', ');
        document.getElementById('hiddenInterestsInput').value = selectedInterests.join(', ');
    }
</script>