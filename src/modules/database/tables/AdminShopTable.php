<?php

namespace modules\database\tables;

require_once "shopTable.php";

class AdminShopTable extends shopTable
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