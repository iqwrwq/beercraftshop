<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\database;

class TableQuery
{
    public $table_query_string;

    /**
     * TableQuery constructor.
     * @param $data array
     */
    public function __construct(array $data)
    {
        $this->table_query_string = $this->convert($data);
    }

    /**
     * @param $data array
     * @return string
     */
    private function convert(array $data)
    {
        $table_query_string = "";
        foreach($data as $key => $field){
            $table_query_string .= $key . " " . $field . ",";
        }
        $table_query_string = rtrim($table_query_string, ", ");
        return $table_query_string;
    }


}