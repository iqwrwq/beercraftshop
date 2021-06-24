<?php


namespace modules\database\tables;


use modules\lib\enum;

class TableType extends enum
{
    const PRODUCT_TABLE = "products";
    const USER_TABLE = "users";
    const ADMIN_TABLE = "admins";
}