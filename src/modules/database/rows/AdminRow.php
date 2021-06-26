<?php


namespace modules\database\rows;

require_once "Row.php";

class AdminRow extends Row
{
    private $loginName;
    private $password;

    public function __construct(array $data)
    {
        parent::__construct((int)$data["id"], $data);
        $this->loginName = $data["login_name"];
        $this->password = $data["password"];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getLoginName()
    {
        return $this->loginName;
    }
}