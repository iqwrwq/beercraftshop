<?php


namespace modules\database\tables;

require_once "Table.php";

class UserTable extends Table
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