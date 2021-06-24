<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\database;

require_once __DIR__ . DIRECTORY_SEPARATOR;

class QueryControllerDep
{

    /**
     * @param string $db_name
     * @param array $table_data
     * @param string $table_name
     * @return string
     */
    public function setUpDataBaseQuery(string $db_name, array $table_data, string $table_name): string
    {
        $tableQuery = new TableQueryDep($table_data);
        return "CREATE TABLE IF NOT EXISTS $db_name.$table_name($tableQuery->table_query_string)";
    }

    /**
     * @param $table
     * @param $data
     * @return string
     */
    public function dataToInsertSql($table,$data): string
    {
        $table_query_string = "INSERT INTO $table VALUES(";
        foreach($data as $key => $field){
            $table_query_string .= ($key === "id" ? "NULL" : "'" . $field . "'") . ",";
        }
        $table_query_string = rtrim($table_query_string, ", ");
        $table_query_string .= ")";
        return $table_query_string;
    }
}