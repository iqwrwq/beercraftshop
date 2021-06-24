<?php


namespace modules\database;


use modules\database\rows\Row;
use modules\database\tables\Table;
use modules\database\tables\TableType;

class ShopDataBaseQueryBuilder
{

    public static function createDataBase($databaseName): string
    {
        return "CREATE DATABASE IF NOT EXISTS " . $databaseName;
    }

    public static function createTable(string $database, string $tableName, array $tableData): string
    {
        $tableSchema = "";
        foreach ($tableData as $key => $fieldType) {
            $tableSchema .= $key . " $fieldType,";
        }
        $tableSchema = rtrim($tableSchema, ", ");
        return "CREATE TABLE IF NOT EXISTS " . $database . $tableName($tableSchema);
    }

    public static function insert(Table $table, Row $row): string
    {
        $insertItemSql = "INSERT INTO " . $table->getName() . " VALUES(";
        foreach ($row->getData() as $key => $field) {
            $insertItemSql .= ($key === "id" ? "NULL" : "'" . $field . "'") . ",";
        }
        $insertItemSql = rtrim($insertItemSql, ", ");
        $insertItemSql .= ")";
        return $insertItemSql;
    }

    public static function get(Table $table, int $id): string
    {
        return "SELECT * from " . $table->getName() . " WHERE id=" . $id;
    }

    public static function getAll(Table $table): string
    {
        return "SELECT * from " . $table->getName();
    }

    public static function delete(Table $fromTable, $id)
    {

    }

    public static function update(TableType $table, int $id, string $key, string $value): string
    {
        return "UPDATE " . $table . "SET " . $key . "='" . $value . "' WHERE id='$id'";
    }

    public function setUpDataBaseQuery(string $db_name, array $table_data, string $table_name): string
    {
        $tableQuery = $this->tableQuery($table_data);
        return "CREATE TABLE IF NOT EXISTS " . $db_name . $table_name($tableQuery);
    }

    private function tableQuery($data): string
    {
        $table_query_string = "";
        foreach ($data as $key => $field) {
            $table_query_string .= $key . " " . $field . ",";
        }
        return rtrim($table_query_string, ", ");
    }
}