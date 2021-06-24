<?php


namespace modules\database\rows;


abstract class Row
{
    private $id;
    private $data;

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getData(): array
    {
        return $this->data;
    }

    abstract public static function checkFormat(array $data): bool;

    abstract public static function convert(array $data): Row;
}