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
    private $harmony;

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
        $this->harmony = '';
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
        if (is_string($musicPreferences)) {
            $musicPreferences = explode(', ', $musicPreferences);
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
            throw new Exception("First Name be longer than 255 characters.");
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
            throw new Exception("Last Name be longer than 255 characters.");
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

    $lastId = getLastUserId($csvFile) + 1;

    $user = new UserEntity(
        $lastId,
        $username,
        $password,
    );

    $user->setUpdatedAt(date('Y-m-d H:i:s'));

    if (($handle = fopen($csvFile, 'a')) !== FALSE) {
        $csvRow = [
            $user->getId(),
            $user->getCreatedAt(),
            $user->getUpdatedAt(),
            $user->getUsername(),
            $user->getPassword(),
        ];

        fputcsv($handle, $csvRow);
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

function getUserById($userId, $csvFile)
{
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] == $userId) {
                $user = new UserEntity(
                    $data[0],
                    $data[3],
                    $data[4]
                );
                fclose($handle);
                return $user;
            }
        }
        fclose($handle);
    }
    return null;
}
