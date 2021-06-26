<?php


namespace config;


class ShopConfig
{
    private $configFile;
    private $dataBaseConfig;
    private $tables;
    private $isShopInstalled;
    private $storeFrontStatus;
    private $fastModeStatus;

    public function __construct()
    {
        $this->configFile = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/config/config.json";
        $json = $this->decode();
        $this->dataBaseConfig = $json["config"]["database"];
        $this->tables = $json["tables"];
        $this->isShopInstalled = $json["config"]["installed"] === "true";
        $this->storeFrontStatus = $json["config"]["storefront"] === "on";
        $this->fastModeStatus = $json["config"]["fast_mode"] === "true";
    }

    public function configure(array $data)
    {
        $this->setDataBaseConfig("database", "host", $data["host"]);
        $this->setDataBaseConfig("database", "user", $data["user"]);
        $this->setDataBaseConfig("database", "pwd", $data["pwd"]);
        $this->setDataBaseConfig("database", "db_name", "beer_craft_shop_database");
    }

    public function get(string $property, string $key)
    {
        $configFileJson = $this->decode();
        return $configFileJson['config'][$property][$key];
    }

    public function set(string $key, string $value)
    {
        $converted = $this->decode();
        $converted['config'][$key] = $value;
        $this->safe($converted);
    }

    public function setDataBaseConfig(string $property, string $key, string $value)
    {
        $converted = $this->decode();
        $converted['config'][$property][$key] = $value;
        $this->safe($converted);
    }

    public function getTables(): array
    {
        return $this->tables;
    }

    public function getDataBaseConfig(): array
    {
        return $this->dataBaseConfig;
    }

    public function getIsShopInstalled(): bool
    {
        return $this->isShopInstalled;
    }
    public function getIsStoreFrontOpen(): bool
    {
        return $this->storeFrontStatus;
    }

    public function toggleStoreFront(){
        if ($this->storeFrontStatus){
            $this->set("storefront", "off");
        }else{
            $this->set("storefront", "on");
        }
    }

    public function getFastMode():bool
    {
        return $this->fastModeStatus;
    }

    public function toggleFastMode(){
        if ($this->fastModeStatus){
            $this->set("fast_mode", "false");
        }else{
            $this->set("fast_mode", "true");
        }
    }

    private function decode()
    {
        $configFileJson = file_get_contents($this->configFile);
        return json_decode($configFileJson, true);
    }

    private function safe(array $json)
    {
        file_put_contents($this->configFile, json_encode($json,JSON_PRETTY_PRINT));
    }

}

if (isset($_POST["storeFrontToggle"])){
    $shopConfig = new ShopConfig();
    $shopConfig->toggleStoreFront();
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin/");
}

if (isset($_POST["fastModeToggle"])){
    $shopConfig = new ShopConfig();
    $shopConfig->toggleFastMode();
    unset($_POST);
    header("Location: /BeerCraftShop/public/admin/");
}