<?php


namespace modules\database\tables;

require_once "shopTable.php";

class UserShopTable extends shopTable
{
    public function __construct(array $rows = array())
    {
        parent::__construct("users", $rows, new TableType("users"));
    }

    function getFormat(): array
    {
        return array("id", "firstname", "lastname", "email", "password");
    }
}