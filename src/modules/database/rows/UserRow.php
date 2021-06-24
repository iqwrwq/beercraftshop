<?php


namespace modules\database\rows;


class UserRow extends Row
{
    private $firstName;
    private $lastName;
    private $email;
    private $userPassword;

    public function __construct(array $data)
    {
            parent::__construct($data["id"], $data);
            $this->firstName = $data["firstname"];
            $this->lastName = $data["lastname"];
            $this->email = $data["email"];
            $this->userPassword = $data["user_password"];
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUserPassword()
    {
        return $this->userPassword;
    }

    public static function checkFormat(array $providedData): bool
    {
        return
            isset($providedData["id"]) &&
            isset($providedData["firstname"]) &&
            isset($providedData["lastname"]) &&
            isset($providedData["email"]) &&
            isset($providedData["user_password"]);
    }
}