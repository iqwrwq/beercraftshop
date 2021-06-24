<?php


namespace modules\database;


use modules\database\rows\Row;
use modules\database\rows\RowType;
use modules\database\tables\Table;

abstract class DataBaseHandler
{
    protected $connection;

    public function __construct($host, $user, $pwd)
    {
        $this->connection = mysqli_connect($host, $user, $pwd);
    }

    abstract public function get(Table $fromTable,int $byId): Row;

    abstract public function getAll(Table $fromTable): Table;

    abstract public function update(Table $fromTable, int $byId, $key, $newValue);

    abstract public static function canConnectToDatabase(string $host,string $user,string $pwd): bool;

}