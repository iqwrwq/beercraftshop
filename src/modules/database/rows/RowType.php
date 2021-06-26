<?php


namespace modules\database\rows;

use modules\lib\enum;

require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/lib/enum.php";

class RowType extends enum
{
    const PRODUCT_ROW = "products";
    const USER_ROW = "users";
    const ADMIN_ROW = "admins";
}