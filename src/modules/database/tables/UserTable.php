<?php


namespace modules\database\tables;


use modules\lib\enum;

class UserTable extends Table
{
    public function __construct(array $rows = array())
    {
        parent::__construct("users", $rows, new TableType("users"));
    }

    public static function checkFormat(array $providedData): bool
    {
        // TODO: Implement checkFormat() method.
    }

    public static function convert(): Table
    {
        // TODO: Implement convert() method.
    }
}