<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\database;

require_once __DIR__ . DIRECTORY_SEPARATOR . "TableQuery.php";

class QueryController
{

    /**
     * @param string $db_name
     * @param array $table_data
     * @param string $table_name
     * @return string
     */
    public function setUpDataBaseQuery(string $db_name, array $table_data, string $table_name): string
    {
        $tableQuery = new TableQuery($table_data);
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

    public function removeByIdSql($table, $id){
        return "DELETE FROM $table WHERE id='$id';";
    }

    /**
     * @param $table
     * @param array $data
     */
    public function updateByIdSql($table, $data){
        $updateStr = "";
        foreach($data as $key => $value){
            if ($key === "id"){
                continue;
            }
            $updateStr .= "$key=$value,";
        }
        $updateStr = rtrim($updateStr, ", ");
        return "UPDATE $table SET " . $updateStr . " WHERE id = " . $data["id"] . ";";
    }
}