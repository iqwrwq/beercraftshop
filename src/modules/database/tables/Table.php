<?php


namespace modules\database\tables;


use modules\database\rows\Row;

abstract class Table
{
    private $name;
    private $rows;
    public $type;

    public function __construct(string $table_name, array $rows, TableType $type)
    {
        $this->name = $table_name;
        $this->rows = $rows;
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function getRow(int $byId)
    {
        foreach ($this->rows as $row) {
            if ($byId === $row["id"]) {
                return $row;
            }
        }
        return false;
    }

    public function getRowFrom(string $where, string $is)
    {
        foreach ($this->rows as $row) {
            if ($where === $row[$is]) {
                return $row;
            }
        }
        return false;
    }

    abstract public static function checkFormat(array $providedData): bool;

    public static function convert(array $data, TableType $type): Table
    {
        if ($type == TableType::ADMIN_TABLE) {
            return new AdminTable($data);
        } elseif ($type == TableType::PRODUCT_TABLE) {
            return new ProductTable($data);
        } elseif ($type == TableType::USER_TABLE) {
            return new UserTable($data);
        }
    }

}