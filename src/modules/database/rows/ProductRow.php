<?php


namespace modules\database\rows;

require_once "Row.php";

class ProductRow extends Row
{
    private $name;
    private $description;
    private $price;
    private $img_url;
    private $percentage;

    public function __construct(array $data)
    {
        parent::__construct((int)$data["id"], $data);
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

}