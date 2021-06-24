<?php


namespace modules\database\rows;

class AdminRow extends Row
{
    private $loginName;
    private $password;

    public function __construct(array $data)
    {
        parent::__construct($data["id"], $data);
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

    public static function checkFormat(array $providedData): bool
    {
        return
            isset($providedData["id"]) &&
            isset($providedData["login_name"]) &&
            isset($providedData["password"]);
    }

    public static function convert(array $data): Row
    {
        // TODO: Implement convert() method.
    }
}