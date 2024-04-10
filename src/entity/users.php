<?php

class UserEntity
{
    private $id;
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
    private $interests;
    private $profileHeadline;
    private $favoriteQuote;
    private $bio;
    private $aboutMe;
    private $idealMatchDescription;
    private $harmony;

    public function __construct($id, $username, $password, $firstName, $lastName, $gender, $dateOfBirth, $country, $city, $lookingFor, $musicPreferences, $photos, $occupation, $smokingStatus, $hobbies, $interests, $profileHeadline, $favoriteQuote, $bio, $aboutMe, $idealMatchDescription, $harmony)
    {
        $this->id = $id;
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setGender($gender);
        $this->setDateOfBirth($dateOfBirth);
        $this->setCountry($country);
        $this->setCity($city);
        $this->setLookingFor($lookingFor);
        $this->setMusicPreferences($musicPreferences);
        $this->setPhotos($photos);
        $this->setOccupation($occupation);
        $this->setSmokingStatus($smokingStatus);
        $this->setHobbies($hobbies);
        $this->setInterests($interests);
        $this->setProfileHeadline($profileHeadline);
        $this->setFavoriteQuote($favoriteQuote);
        $this->setBio($bio);
        $this->setAboutMe($aboutMe);
        $this->setIdealMatchDescription($idealMatchDescription);
        $this->harmony = $harmony;
    }

    // Getters
    public function getId()
    {
        return $this->id;
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

    public function getInterests()
    {
        return $this->interests;
    }

    public function getProfileHeadline()
    {
        return $this->profileHeadline;
    }

    public function getFavoriteQuote()
    {
        return $this->favoriteQuote;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    public function getIdealMatchDescription()
    {
        return $this->idealMatchDescription;
    }

    // Setters
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
        if (empty($firstName)) {
            throw new Exception("First name cannot be empty.");
        }
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        if (empty($lastName)) {
            throw new Exception("Last name cannot be empty.");
        }
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
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateOfBirth)) {
            throw new Exception("Invalid date format. Expected YYYY-MM-DD.");
        }
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setCountry($country)
    {
        if (empty($country)) {
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
        $validOptions = ['Male', 'Female', 'Both', 'Other'];
        if (!in_array($lookingFor, $validOptions)) {
            throw new Exception("Invalid option for 'looking for'.");
        }
        $this->lookingFor = $lookingFor;
    }

    public function setMusicPreferences($musicPreferences)
    {
        if (!is_array($musicPreferences)) {
            throw new Exception("Music preferences should be an array.");
        }
        $this->musicPreferences = $musicPreferences;
    }

    public function setPhotos($photos)
    {
        if (!is_array($photos)) {
            throw new Exception("Photos should be an array.");
        }
        $this->photos = $photos;
    }

    public function setOccupation($occupation)
    {
        if (empty($occupation)) {
            throw new Exception("Occupation cannot be empty.");
        }
        $this->occupation = $occupation;
    }

    public function setSmokingStatus($smokingStatus)
    {
        $validStatuses = ['Yes', 'No'];
        if (!in_array($smokingStatus, $validStatuses)) {
            throw new Exception("Invalid smoking status.");
        }
        $this->smokingStatus = $smokingStatus;
    }

    public function setHobbies($hobbies)
    {
        if (!is_string($hobbies)) {
            throw new Exception("Hobbies should be a string.");
        }
        $this->hobbies = $hobbies;
    }

    public function setInterests($interests)
    {
        if (!is_string($interests)) {
            throw new Exception("Interests should be a string.");
        }
        $this->interests = $interests;
    }

    public function setProfileHeadline($profileHeadline)
    {
        if (empty($profileHeadline)) {
            throw new Exception("Profile headline cannot be empty.");
        }
        $this->profileHeadline = $profileHeadline;
    }

    public function setFavoriteQuote($favoriteQuote)
    {
        if (empty($favoriteQuote)) {
            throw new Exception("Favorite quote cannot be empty.");
        }
        $this->favoriteQuote = $favoriteQuote;
    }

    public function setBio($bio)
    {
        if (empty($bio)) {
            throw new Exception("Bio cannot be empty.");
        }
        $this->bio = $bio;
    }

    public function setAboutMe($aboutMe)
    {
        if (empty($aboutMe)) {
            throw new Exception("About me cannot be empty.");
        }
        $this->aboutMe = $aboutMe;
    }

    public function setIdealMatchDescription($idealMatchDescription)
    {
        if (empty($idealMatchDescription)) {
            throw new Exception("Ideal match description cannot be empty.");
        }
        $this->idealMatchDescription = $idealMatchDescription;
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

    private function validateDateOfBirth($date)
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        list($year, $month, $day) = explode('-', $date);
        return checkdate((int)$month, (int)$day, (int)$year);
    }

    private function validateMusicPreferences($musicPreferences)
    {
        if (!is_array($musicPreferences)) {
            return false;
        }

        foreach ($musicPreferences as $preference) {
            if (!is_string($preference) || empty($preference)) {
                return false;
            }
        }

        return true;
    }

    private function validatePhotos($photos)
    {
        if (!is_array($photos)) {
            return false;
        }

        foreach ($photos as $photo) {
            if (!filter_var($photo, FILTER_VALIDATE_URL)) {
                return false;
            }
        }

        return true;
    }

    private function validateStringField($field)
    {
        return is_string($field) && !empty($field);
    }

    // TODO:
}

// TODO:
function usernameExists($username, $csvFile)
{
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[1] == $username) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

function getLastUserId($csvFile)
{
    $lastId = 0;
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $lastId = (int)$data[0];
        }
        fclose($handle);
    }
    return $lastId;
}

function createUser($username, $password)
{
    $csvFile = '../data/users.csv';

    if (usernameExists($username, $csvFile)) {
        throw new Exception("This username is already taken.");
    }

    $lastId = getLastUserId($csvFile);
    $userId = $lastId + 1;

    $user = new UserEntity($userId, $username, $password);

    if (($handle = fopen($csvFile, 'a')) !== FALSE) {
        fputcsv($handle, [$user->getId(), $user->getUsername(), $user->getPassword()]);
        fclose($handle);
        return $user;
    }

    return null;
}

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
