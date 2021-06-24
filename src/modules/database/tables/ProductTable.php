<?php


namespace modules\database\tables;


class ProductTable extends Table
{
    public function __construct(array $rows = array())
    {
        parent::__construct("products", $rows, new TableType("products"));
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