<?php

namespace modules\database\tables;

require_once "Table.php";

class AdminTable extends Table
{
    public function __construct(array $rows = array())
    {
        parent::__construct("admins", $rows, new TableType("admins"));
    }

    function getFormat(): array
    {
        return array("id", "login_name", "password");
    }

}