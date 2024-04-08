<?php

class UserEntity
{
    private $id;
    private $username;
    private $password;

    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->setUsername($username);
        $this->setPassword($password);
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

    private function validatePassword($password)
    {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password)
            && preg_match('/[^\w]/', $password);
    }
}

function createUser($username, $password)
{
    $csvFile = '../data/users.csv';

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
