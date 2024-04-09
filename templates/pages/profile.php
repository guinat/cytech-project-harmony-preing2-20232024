<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/tailwind.config.js"></script>
    <title>Complete Your Profile</title>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-semibold text-gray-800 my-5">Complete Your Profile</h2>

        <form action="/path/to/your/processing/script.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <span class="text-gray-700">Gender</span>
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="gender" value="male">
                        <span class="ml-2">Male</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="gender" value="female">
                        <span class="ml-2">Female</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_of_birth">
                    Date of Birth
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="date_of_birth" type="date" name="date_of_birth">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="occupation">
                    Occupation
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="occupation" type="text" name="occupation" placeholder="Your occupation">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
                    Country of Residence
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" type="text" name="country" placeholder="Country of residence">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="physical_description">
                    Physical Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="physical_description" name="physical_description" placeholder="Describe yourself physically (height, weight, eye color, etc.)"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="personal_info">
                    Personal Information
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="personal_info" name="personal_info" placeholder="Interests, greeting message, quote, etc."></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">
                    Full Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="full_name" type="text" name="full_name" placeholder="Your full name">

                <label class="block text-gray-700 text-sm font-bold mb-2 mt-4" for="address">
                    Full Address
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" name="address" placeholder="Your address"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Complete Registration
                </button>
            </div>
        </form>
    </div>
</body>

</html>