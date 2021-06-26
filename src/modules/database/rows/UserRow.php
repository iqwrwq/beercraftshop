<?php


namespace modules\database\rows;

require_once "Row.php";

class UserRow extends Row
{
    private $firstName;
    private $lastName;
    private $email;
    private $password;

    public function __construct(array $data)
    {
            parent::__construct((int)$data["id"], $data);
            $this->firstName = $data["firstname"];
            $this->lastName = $data["lastname"];
            $this->email = $data["email"];
            $this->password = $data["password"];
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

    public function getPassword()
    {
        return $this->password;
    }
}