<?php


namespace modules\database\tables;

require_once "Table.php";

class ProductTable extends Table
{
    public function __construct(array $rows = array())
    {
        parent::__construct("products", $rows, new TableType("products"));
    }

    function getFormat(): array
    {
        return array("id", "name", "description", "price", "img_url", "percentage");
    }
}