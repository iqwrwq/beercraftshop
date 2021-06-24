<?php

namespace modules\database;

use config\ShopConfig;
use modules\database\rows\ProductRow;
use modules\database\rows\Row;
use modules\database\rows\RowType;
use modules\database\rows\UserRow;
use modules\database\tables\Table;
use mysqli_result;

require_once "DataBaseHandler.php";
require_once "ShopDataBaseQueryBuilder.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";

class ShopDataBaseHandler extends DataBaseHandler
{
    public function __construct(array $data)
    {
        parent::__construct($data["host"], $data["user"], $data["pwd"]);
    }

    public function setupDataBase(string $databaseName,array $tables){

        $this->connection->query(ShopDataBaseQueryBuilder::createDataBase($databaseName));
        foreach ($tables as $table => $data){
            $this->connection->query(ShopDataBaseQueryBuilder::createTable($databaseName,$table, $data));
        }
    }

    public function insert(Table $toTable, Row $row)
    {
        $shopConfig = new ShopConfig();
        $this->connection->select_db($shopConfig->getDataBaseConfig()["db_name"]);
        $this->connection->query(ShopDataBaseQueryBuilder::insert($toTable, $row));
    }


    public function get(Table $fromTable, int $byId): Row
    {
        $shopConfig = new ShopConfig();
        $this->connection->select_db($shopConfig->getDataBaseConfig()["db_name"]);
        return Table::convertResultToTable($this->connection->query(ShopDataBaseQueryBuilder::get($fromTable, $byId)))->getRow($byId);
    }

    public function getAll(Table $fromTable): Table
    {
        $this->connection->select_db($fromTable->getName());
        $rows = $this->castMySqlObjectToArray($this->connection->query(ShopDataBaseQueryBuilder::getAll($fromTable)));
        return Table::convert($rows, $fromTable->type);
    }

    public function getByAssociation(string $fromTable, string $where, string $equals, string $getThis){
        $this->connection->select_db($fromTable);
        return $this->castMySqlObjectToArray($this->connection->query(ShopDataBaseQueryBuilder::getByWhere($fromTable)));
    }

    public function getAllProducts(){
        $shopConfig = new ShopConfig();
        $this->connection->select_db($shopConfig->getDataBaseConfig()["db_name"]);
        return $this->connection->query(ShopDataBaseQueryBuilder::getAll("products"));
    }

    public function update(string $fromTable,int $byId, $key, $newValue)
    {
        $this->connection->select_db($fromTable);
        $this->connection->query(ShopDataBaseQueryBuilder::update($fromTable, $byId, $key, $newValue));
    }

    private function castMySqlObjectToArray(mysqli_result $result)
    {
        if (!$result){
            return false;
        }
        while($row = $result->fetch_row()) {
            $rows[] = $row;
        }
        if (!empty($rows)) {
            return $rows;
        }
    }

    private function convertDataToRowCollection(array $data,RowType $type)
    {
        $rowCollection = array();
        foreach($data as $rowData){
            if ($type === RowType::PRODUCT_ROW){
                $row = ProductRow::convertToProductRow($rowData);
            }elseif ($type === RowType::USER_ROW){
                $row = UserRow::convertToProductRow($rowData);
            }else{
                return false;
            }
            array_push($rowCollection, $row);
        }
        return $rowCollection;
    }

    public static function canConnectToDatabase(string $host,string $user,string $pwd): bool
    {
        if($host === "" && $user === "" && $pwd === ""){
            return false;
            }
        return (bool)mysqli_connect($host, $user, $pwd);
    }
}
