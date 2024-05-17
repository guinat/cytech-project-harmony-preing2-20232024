<?php

class UserEntity
{
    private $id;
    private $created_at;
    private $updated_at;
    private $username;
    private $password;
    private $firstName;
    private $lastName;
    private $gender;
    private $dateOfBirth;
    private $country;
    private $city;
    private $lookingFor;
    private $musicPreferences;
    private $photos;
    private $occupation;
    private $smokingStatus;
    private $hobbies;
    private $aboutMe;
    private $subscription;
    private $subscriptionStartDate;
    private $subscriptionEndDate;

    // Constructor
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = null;
        $this->setUsername($username);
        $this->setPassword($password);
        $this->firstName = '';
        $this->lastName = '';
        $this->gender = '';
        $this->dateOfBirth = '';
        $this->country = '';
        $this->city = '';
        $this->lookingFor = '';
        $this->musicPreferences = [];
        $this->photos = [];
        $this->occupation = '';
        $this->smokingStatus = '';
        $this->hobbies = '';
        $this->aboutMe = '';
        $this->subscription = '';
        $this->subscriptionStartDate = null;
        $this->subscriptionEndDate = null;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function getLookingFor()
    {
        return $this->lookingFor;
    }
    public function getMusicPreferences()
    {
        return $this->musicPreferences;
    }
    public function getPhotos()
    {
        return $this->photos;
    }
    public function getOccupation()
    {
        return $this->occupation;
    }
    public function getSmokingStatus()
    {
        return $this->smokingStatus;
    }
    public function getHobbies()
    {
        return $this->hobbies;
    }
    public function getAboutMe()
    {
        return $this->aboutMe;
    }
    public function getSubscription()
    {
        return $this->subscription;
    }
    public function getSubscriptionStartDate()
    {
        return $this->subscriptionStartDate;
    }
    public function getSubscriptionEndDate()
    {
        return $this->subscriptionEndDate;
    }

    // Setters
    public function setUpdatedAt($date)
    {
        $this->updated_at = $date;
    }

    public function setUsername($username)
    {
        if (empty($username)) {
            throw new Exception("Username cannot be empty.");
        }
        $this->username = $username;
    }

    public function setPassword($password)
    {
        if (!$this->validatePassword($password)) {
            throw new Exception("The password does not meet the security criteria.");
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setFirstName($firstName)
    {
        $this->validateFirstName($firstName);
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->validateLastName($lastName);
        $this->lastName = $lastName;
    }

    public function setGender($gender)
    {
        $validGenders = ['Male', 'Female', 'Other'];
        if (!in_array($gender, $validGenders)) {
            throw new Exception("Invalid gender.");
        }
        $this->gender = $gender;
    }

    public function setDateOfBirth($dateOfBirth)
    {
        if (!$this->validateDateOfBirth($dateOfBirth)) {
            throw new Exception("Invalid date format. Expected YYYY-MM-DD.");
        }
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setCountry($country)
    {
        if (!is_string($country)) {
            throw new Exception("Country cannot be empty.");
        }
        $this->country = $country;
    }

    public function setCity($city)
    {
        if (empty($city)) {
            throw new Exception("City cannot be empty.");
        }
        $this->city = $city;
    }

    public function setLookingFor($lookingFor)
    {
        $validOptions = ['Male', 'Female', 'Both'];
        if (!in_array($lookingFor, $validOptions)) {
            throw new Exception("Invalid option for 'looking for'.");
        }
        $this->lookingFor = $lookingFor;
    }

    public function setMusicPreferences($musicPreferences)
    {
        if (!is_string($musicPreferences) || empty($musicPreferences)) {
            throw new Exception("Music preferences should be a string.");
        }
        $this->musicPreferences = $musicPreferences;
    }

    public function setPhotos($photos)
    {
        if (!is_array($photos) || count($photos) < 2) {
            throw new Exception("Photos should be an array with at least 2 photos.");
        }
        $this->photos = $photos;
    }

    public function setOccupation($occupation)
    {
        if (!is_string($occupation)) {
            throw new Exception("Occupation must be a string.");
        }
        $this->occupation = $occupation;
    }

    public function setSmokingStatus($smokingStatus)
    {
        $this->smokingStatus = $smokingStatus;
    }

    public function setHobbies($hobbies)
    {
        if (!is_string($hobbies)) {
            throw new Exception("Hobbies should be a string.");
        }
        $this->hobbies = $hobbies;
    }

    public function setAboutMe($aboutMe)
    {
        if (!is_string($aboutMe)) {
            throw new Exception("About me must be a string.");
        }
        $this->aboutMe = $aboutMe;
    }

    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }

    public function setSubscriptionStartDate($subscriptionStartDate)
    {
        $this->subscriptionStartDate = $subscriptionStartDate;
    }

    public function setSubscriptionEndDate($subscriptionEndDate)
    {
        $this->subscriptionEndDate = $subscriptionEndDate;
    }

    // Validators
    private function validatePassword($password)
    {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password)
            && preg_match('/[^\w]/', $password);
    }

    private function validateFirstName($field)
    {
        if (!is_string($field) || empty($field)) {
            throw new Exception("First Name must be a non-empty string.");
        }
        if (strlen($field) > 255) {
            throw new Exception("First Name cannot be longer than 255 characters.");
        }
        if (preg_match('/\d/', $field)) {
            throw new Exception("First Name cannot contain numbers.");
        }
    }

    private function validateLastName($field)
    {
        if (!is_string($field) || empty($field)) {
            throw new Exception("Last Name must be a non-empty string.");
        }
        if (strlen($field) > 255) {
            throw new Exception("Last Name cannot be longer than 255 characters.");
        }
        if (preg_match('/\d/', $field)) {
            throw new Exception("Last Name cannot contain numbers.");
        }
    }

    private function validateDateOfBirth($date)
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        list($year, $month, $day) = explode('-', $date);
        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            return false;
        }

        $currentYear = date('Y');
        $age = $currentYear - $year;

        return $age >= 18 && $age <= 118;
    }
}

// Function to check if a username exists in the CSV file
function usernameExists($username, $csvFile)
{
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[3] == $username) { // Assuming username is at index 3
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

// Function to get the last user ID in the CSV file
function getLastUserId($csvFile)
{
    $lastId = 0;
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $lastId = (int)$data[0]; // Assuming user ID is at index 0
        }
        fclose($handle);
    }
    return $lastId;
}

// Function to create a new user
function createUser($username, $password)
{
    $csvFile = '../data/users.csv';

    if (usernameExists($username, $csvFile)) {
        throw new Exception("This username is already taken.");
    }

    $lastId = getLastUserId($csvFile) + 1;

    $user = new UserEntity($lastId, $username, $password);
    $user->setUpdatedAt(date('Y-m-d H:i:s'));

    if (($handle = fopen($csvFile, 'a')) !== FALSE) {
        $csvRow = [
            $user->getId(),
            $user->getCreatedAt(),
            $user->getUpdatedAt(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getGender(),
            $user->getDateOfBirth(),
            $user->getCountry(),
            $user->getCity(),
            $user->getLookingFor(),
            $user->getMusicPreferences(),
            implode('|', $user->getPhotos()),
            $user->getOccupation(),
            $user->getSmokingStatus(),
            $user->getHobbies(),
            $user->getAboutMe(),
            $user->getSubscription(),
            $user->getSubscriptionStartDate(),
            $user->getSubscriptionEndDate(),
        ];

        fputcsv($handle, $csvRow);
        fclose($handle);

        return $user;
    }

    return null;
}

// Function to update a user profile
function updateUserProfile($userId, $dataToUpdate, $csvFile)
{
    $tempFile = tempnam(sys_get_temp_dir(), 'CSV');
    $dataUpdated = false;

    if (($input = fopen($csvFile, 'r')) !== FALSE) {
        $output = fopen($tempFile, 'w');

        while (($data = fgetcsv($input, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $data = array_replace($data, $dataToUpdate);
                $dataUpdated = true;
            }
            fputcsv($output, $data);
        }

        fclose($input);
        fclose($output);

        if ($dataUpdated) {
            rename($tempFile, $csvFile);
        } else {
            unlink($tempFile);
        }
    }

    return $dataUpdated;
}

// Function to get a user by ID
function getUserById($userId, $csvFile)
{
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $header = fgetcsv($handle); // Skip header row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $user = new UserEntity(
                    $data[0], // User ID
                    $data[3], // Username
                    $data[4]  // Password
                );
                fclose($handle);
                return $user;
            }
        }
        fclose($handle);
    }
    return null;
}


// Function to get a user by ID with all profile details
function getUser($userId, $csvFilePath)
{
    if (($handle = fopen($csvFilePath, 'r')) !== FALSE) {
        fgetcsv($handle); // Skip header row
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $user = new UserEntity($data[0], $data[3], $data[4]);
                if (isset($data[6])) $user->setFirstName($data[6]);
                if (isset($data[7])) $user->setLastName($data[7]);
                if (isset($data[8])) $user->setGender($data[8]);
                if (isset($data[9])) $user->setDateOfBirth($data[9]);
                if (isset($data[10])) $user->setCountry($data[10]);
                if (isset($data[11])) $user->setCity($data[11]);
                if (isset($data[12])) $user->setLookingFor($data[12]);
                if (isset($data[13])) $user->setMusicPreferences($data[13]);
                if (isset($data[14])) $user->setPhotos(array_slice($data, 14, 4));
                if (isset($data[18])) $user->setOccupation($data[18]);
                if (isset($data[19])) $user->setSmokingStatus($data[19]);
                if (isset($data[20])) $user->setHobbies($data[20]);
                if (isset($data[21])) $user->setAboutMe($data[21]);
                if (isset($data[22])) $user->setSubscription($data[22]);
                if (isset($data[23])) $user->setSubscriptionStartDate($data[23]);
                if (isset($data[24])) $user->setSubscriptionEndDate($data[24]);
                fclose($handle);
                return $user;
            }
        }
        fclose($handle);
    }
    return null;
}
