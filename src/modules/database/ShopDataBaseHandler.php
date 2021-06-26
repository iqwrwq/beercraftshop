<?php

namespace modules\database;

use config\ShopConfig;
use modules\database\rows\Row;
use modules\database\rows\RowType;
use modules\database\tables\Table;
use modules\database\tables\TableType;

require_once "DataBaseHandler.php";
require_once "ShopDataBaseQueryBuilder.php";
require_once "tables/TableType.php";
require_once "rows/RowType.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/ShopConfig.php";

class ShopDataBaseHandler extends DataBaseHandler
{
    private $shopConfig;
    private $dataBaseName;

    public function __construct(array $data)
    {
        parent::__construct($data["host"], $data["user"], $data["pwd"]);
        $this->shopConfig = new ShopConfig();
        $this->dataBaseName = $this->shopConfig->getDataBaseConfig()["db_name"];
    }

    public function setupDataBase(array $tables)
    {

        $this->connection->query(ShopDataBaseQueryBuilder::createDataBase($this->dataBaseName));
        foreach ($tables as $table => $data) {
            $this->connection->query(ShopDataBaseQueryBuilder::createTable(new TableType($table)));
        }
    }

    public function insert(TableType $toTable, Row $row)
    {
        $this->connection->select_db($this->dataBaseName);
        $this->connection->query(ShopDataBaseQueryBuilder::insert($toTable, $row));
    }

    public function get(TableType $fromTable, int $byId): Row
    {
        $rowType = new RowType($fromTable->value);
        $this->connection->select_db($this->dataBaseName);
        $resultData = $this->connection->query(ShopDataBaseQueryBuilder::get($fromTable, $byId))->fetch_array();
        return Row::convert($resultData, $rowType);
    }

    public function getByAssociation(TableType $fromTable, string $where, string $equals, string $getThis)
    {
        $rowType = new RowType($fromTable->value);
        $this->connection->select_db($this->dataBaseName);
        $resultData = $this->connection->query(ShopDataBaseQueryBuilder::getByWhere($fromTable));
        return Row::convert($resultData, $rowType);
    }

    public function getAll(TableType $fromTable): Table
    {
        $rowCollection = array();
        $rowType = new RowType($fromTable->value);
        $this->connection->select_db($this->dataBaseName);
        $result = $this->connection->query(ShopDataBaseQueryBuilder::getAll($fromTable));
        while ($resultData = $result->fetch_assoc()) {
            array_push($rowCollection, Row::convert($resultData, $rowType));
        }
        return Table::convert($rowCollection, $fromTable);
    }

    public function update(TableType $fromTable, int $byId, $key, $newValue)
    {
        $this->connection->select_db($fromTable->value);
        $this->connection->query(ShopDataBaseQueryBuilder::update($fromTable, $byId, $key, $newValue));
    }

    public static function canConnectToDatabase(string $host, string $user, string $pwd): bool
    {
        if ($host === "" && $user === "" && $pwd === "") {
            return false;
        }
        return (bool)mysqli_connect($host, $user, $pwd);
    }
}
