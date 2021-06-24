<?php


namespace modules\database\rows;


class ProductRow extends Row
{
    private $name;
    private $description;
    private $price;
    private $img_url;
    private $percentage;

    public function __construct(array $data)
    {
        parent::__construct($data["id"], $data);
        $this->name = $data["name"];
        $this->description = $data["description"];
        $this->price = $data["price"];
        $this->img_url = $data["img_url"];
        $this->percentage = $data["percentage"];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImgUrl(): string
    {
        return $this->img_url;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public static function checkFormat(array $providedData): bool
    {
        return
            isset($providedData["id"]) &&
            isset($providedData["name"]) &&
            isset($providedData["description"]) &&
            isset($providedData["price"]) &&
            isset($providedData["img_url"]) &&
            isset($providedData["percentage"]);
    }

    public static function convert(array $data): Row
    {
        // TODO: Implement convert() method.
    }
}