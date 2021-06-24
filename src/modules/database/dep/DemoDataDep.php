<?php


use BeerCraftShop\src\modules\database\DataBaseControllerDep;


class DemoDataDep
{
    public function insert_demo_data(DataBaseControllerDep $dataBaseController, PropertiesDepControllerDep $propertiesController)
    {
        if ($propertiesController->get("insertDemoData") === "true" && $propertiesController->get("demoDataInserted") === "false") {
            $json = file_get_contents("https://iqwrwq.github.io/beercraftshop/data/products/products.json");
            $data = json_decode($json);
            $product_image_path = "../../../public/resources/images/products/";
            $api_url = "https://iqwrwq.github.io/beercraftshop/data/products/img/";
            foreach ($data as $product) {
                $product_data = array();
                foreach ($product as $key => $value) {
                    if ($key === "img_url") {
                        file_put_contents($product_image_path . $value . ".jpg", file_get_contents($api_url . $value . ".jpg"));
                    }
                    $product_data[$key] = $value;
                }
                $dataBaseController->insertProduct("products",$product_data);
            }
        }

    }
}