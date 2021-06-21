<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\database;

use DemoData;
use mysqli;

class DataBase
{
    /**
     * @var mysqli
     */
    protected $connection;
    private $host;
    private $db_user;
    private $db_pwd;

    public function __construct($host, $db_user,$db_pwd)
    {
        $this->host = $host;
        $this->db_user = $db_user;
        $this->db_pwd = $db_pwd;
    }

    /**
     * @return bool
     */
    protected function connect(): bool
    {
        $this->connection = mysqli_connect($this->host, $this->db_user, $this->db_pwd);
        if ($this->connection->connect_error) {
            return false;
        }
        return true;
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    protected function database_query($sql)
    {
        $query = $this->connection->query($sql);
        return $query ? $query : false;
    }
}