<?php


namespace modules\database;


use config\ShopConfig;
use modules\database\rows\Row;
use modules\database\tables\shopTable;
use modules\database\tables\TableType;

class ShopDataBaseQueryBuilder
{

    public static function createDataBase($databaseName): string
    {
        return "CREATE DATABASE IF NOT EXISTS " . $databaseName;
    }

    public static function createTable(TableType $table): string
    {
        $shopConfig = new ShopConfig();
        $tables = $shopConfig->getTables();
        $database = $shopConfig->getDataBaseConfig()["db_name"];
        $tableSchema = "";

        foreach ($tables[$table->value] as $key => $fieldType) {
            $tableSchema .= $key . " $fieldType,";
        }
        $tableSchema = rtrim($tableSchema, ", ");
        return "CREATE TABLE IF NOT EXISTS " . $database . "." . $table->value . "(" . $tableSchema . ")";
    }

    public static function insert(TableType $table, Row $row): string
    {
        $insertItemSql = "INSERT INTO " . $table->value . " VALUES(";
        foreach ($row->getData() as $key => $field) {
            if ($key === "password") {
                $insertItemSql .= "'" . password_hash($key, PASSWORD_BCRYPT) . "',";
            } else {
                $insertItemSql .= ($key === "id" ? "NULL" : "'" . $field . "'") . ",";
            }
        }
        $insertItemSql = rtrim($insertItemSql, ", ");
        $insertItemSql .= ")";
        return $insertItemSql;
    }

    public static function get(TableType $table, int $id): string
    {
        return "SELECT * from " . $table->value . " WHERE id=" . $id;
    }

    public static function getAll(TableType $table): string
    {
        return "SELECT * from " . $table->value;
    }

    public static function delete(TableType $table, $id)
    {
        return "DELETE FROM " . $table->value . " WHERE id='$id'";
    }

    public static function update(TableType $table, int $id, string $key, string $value): string
    {
        return "UPDATE " . $table->value . " SET " . $key . "='" . $value . "' WHERE id='$id'";
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