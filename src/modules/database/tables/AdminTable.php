<?php


namespace modules\database\tables;


use modules\lib\enum;

class AdminTable extends Table
{
    public function __construct(array $rows = array())
    {
        parent::__construct("admins", $rows, new TableType("admins"));
    }

    public static function checkFormat(array $providedData): bool
    {
        // TODO: Implement checkFormat() method.
    }

}