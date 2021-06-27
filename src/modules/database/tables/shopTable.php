<?php


namespace modules\database\tables;

require_once "UserShopTable.php";
require_once "AdminShopTable.php";
require_once "ProductShopTable.php";


abstract class shopTable
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

    public function count(){
        return sizeof($this->rows);
    }

    abstract function getFormat(): array;

    public function getRowFrom(string $where, string $is)
    {
        foreach ($this->rows as $row){
            $data = $row->getData();
            foreach ($data as $prop => $value){
                if($prop === $where && $value === $is){
                    return $row;
                }
            }
        }
        return false;
    }

    public static function convert(array $data, TableType $type): shopTable
    {
        if ($type == TableType::ADMIN_TABLE) {
            return new AdminShopTable($data);
        } elseif ($type == TableType::PRODUCT_TABLE) {
            return new ProductShopTable($data);
        } elseif ($type == TableType::USER_TABLE) {
            return new UserShopTable($data);
        }
    }

}