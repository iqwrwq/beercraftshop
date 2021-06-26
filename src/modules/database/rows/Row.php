<?php


namespace modules\database\rows;

require_once "ProductRow.php";
require_once "AdminRow.php";
require_once "UserRow.php";

abstract class Row
{
    private $id;
    private $data;

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public static function convert(array $data, RowType $type): Row
    {
        if ($type == RowType::PRODUCT_ROW) {
            return new ProductRow($data);
        } elseif ($type == RowType::ADMIN_ROW) {
            return new AdminRow($data);
        } elseif ($type == RowType::USER_ROW) {
            return new UserRow($data);
        }
    }
}