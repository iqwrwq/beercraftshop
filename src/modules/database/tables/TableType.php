<?php


namespace modules\database\tables;


use modules\lib\enum;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/lib/enum.php";

class TableType extends enum
{
    const PRODUCT_TABLE = "products";
    const USER_TABLE = "users";
    const ADMIN_TABLE = "admins";
}