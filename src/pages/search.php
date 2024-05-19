<?php

// Function to load profiles from a CSV file
function loadProfiles($filepath)
{
    $profiles = [];
    // Open the CSV file for reading
    if (($handle = fopen($filepath, "r")) !== FALSE) {
        // Read the header row
        $header = fgetcsv($handle, 1000, ",");
        if ($header === FALSE) {
            // Output error if header cannot be read
            echo '<p>Error: Unable to read header from CSV file.</p>';
            return $profiles;
        }

        // Read each data row and combine with header
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) == count($header)) {
                // Combine header and data to create associative array
                $profiles[] = array_combine($header, $data);
            } else {
                // Output error if data row does not match header count
                echo '<p>Error: Data row does not match header count:</p>';
                echo '<pre>' . htmlspecialchars(json_encode($data)) . '</pre>';
            }
        }
        // Close the file after reading
        fclose($handle);
    } else {
        // Output error if file cannot be opened
        echo '<p>Error: Unable to open CSV file.</p>';
    }
    return $profiles;
}

// Function to search profiles for a given keyword
function searchProfiles($profiles, $keyword)
{
    $results = [];
    // Iterate through each profile
    foreach ($profiles as $profile) {
        // Iterate through each field in the profile
        foreach ($profile as $value) {
            // Check if the keyword exists in the field (case-insensitive)
            if (stripos($value, $keyword) !== FALSE) {
                // Add profile to results if keyword is found
                $results[] = $profile;
                break;
            }
        }
    }
    return $results;
}

// Get the search keyword from the URL parameters
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if ($keyword) {
    // Load profiles from the CSV file
    $profiles = loadProfiles('../data/users.csv');
    if ($profiles) {
        // Search profiles for the keyword
        $results = searchProfiles($profiles, $keyword);
        // Check if any results were found
        if (count($results) > 0) : ?>
            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach ($results as $result) : ?>
                    <a href="profile.php?id=<?php echo htmlspecialchars($result['id']); ?>" class="text-white bg-black rounded-lg shadow-lg p-4 w-[290px] md:w-[330px]">
                        <!-- Display profile image -->
                        <div class="bg-cover bg-center h-48 rounded-t-lg" style="background-image: url('<?php echo htmlspecialchars($result['require_photo_1']); ?>');"></div>
                        <div class="p-4">
                            <!-- Display profile details -->
                            <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($result['first_name'] . ' ' . $result['last_name']); ?></h2>
                            <p class="text-sm">Gender: <?php echo htmlspecialchars($result['gender']); ?></p>
                            <p class="text-sm">Music Preferences: <?php echo htmlspecialchars($result['music_preferences']); ?></p>
                            <p class="text-sm">Hobbies: <?php echo htmlspecialchars($result['hobbies']); ?></p>
                            <p class="text-sm">About Me: <?php echo htmlspecialchars($result['about_me']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <!-- Output message if no results found -->
            <p>No results found.</p>
<?php endif;
    } else {
        // Debug: Output error if no profiles are loaded
        echo '<p>Error: No profiles loaded.</p>';
    }
} else {
    // Debug: Output error if no keyword is provided
    echo '<p>Error: No keyword provided.</p>';
}
?>