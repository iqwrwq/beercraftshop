<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\database;

require_once __DIR__ . DIRECTORY_SEPARATOR;
require_once __DIR__ . DIRECTORY_SEPARATOR;
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";

use mysqli_result;

class DataBaseControllerDep extends DataBase
{
    private $db_name;

    /**
     * Constructs and Connects Database.
     * Notice that everything must be tested before and database must be created
     * @param $host
     * @param $db_pwd
     * @param $db_user
     * @param $db_name
     */
    public function __construct($host, $db_user, $db_pwd, $db_name)
    {
        parent::__construct($host, $db_user, $db_pwd);
        $this->db_name = $db_name;
        $this->connect();
    }

    /**
     * @param $table_data
     * @param $table_name
     * @return bool
     */
    public function init($table_data, $table_name): bool
    {
        if ($this->database_query("CREATE DATABASE IF NOT EXISTS $this->db_name ")) {
            $queryController = new QueryControllerDep();
            if ($this->database_query($queryController->setUpDataBaseQuery($this->db_name, $table_data, $table_name))) {
                $this->goodToGo();
            } else {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param $table
     * @param $data
     */
    public function insertProduct($table, $data)
    {
        $queryController = new QueryControllerDep();
        $sql = $queryController->dataToInsertSql($table, $data);
        $this->connection->select_db($this->db_name);
        $this->connection->query($sql);
    }

    /**
     * @return bool|mysqli_result
     */
    public function getAllProducts()
    {
        $this->connection->select_db($this->db_name);
        $sql = "SELECT * FROM products";
        return $this->connection->query($sql);
    }


    /**
     * @return void
     */
    private function goodToGo()
    {
        $this->connection->select_db($this->db_name);
    }

    /**
     * Checks Connection to DataBase and optionally if Database exists
     * @param $data
     * @param bool $check_database
     * @return bool
     */
    public static function check($data, bool $check_database = false): bool
    {
        if (isset($data["db_host"]) && isset($data["db_user"]) && isset($data["db_pwd"])) {
            if (!mysqli_connect($data["db_host"], $data["db_user"], $data["db_pwd"])) {
                return false;
            }
            if ($check_database) {
                if (!mysqli_connect($data["db_host"], $data["db_user"], $data["db_pwd"])->select_db($data["db_name"])) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (checkData()) {
        $properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
        $propertiesController = new \PropertiesDepControllerDep($properties_path);
        $dataBaseController = new DataBaseControllerDep(
            $propertiesController->get("db_host"),
            $propertiesController->get("db_user"),
            $propertiesController->get("db_pwd"),
            $propertiesController->get("db_name")
        );
        $newProduct = array(
            "id" => "NULL",
            "name" => $_POST["addItemName"],
            "description" => returnDescriptionFileContent(),
            "price" => $_POST["addItemPrice"],
            "img_url" => handleUploadedProductImageReturnURL(),
            "alcohol_content" => $_POST["addItemAlcoholContent"]
        );
        $dataBaseController->insertProduct("products", $newProduct);
        unset($_POST);
        unset($_FILES);
        header("Location: /BeerCraftShop/public/admin");
    } else {
        returnWithError("Creation Error: Could not create item, check data!");
    }
}

/**
 * @return string
 */
function returnDescriptionFileContent():string
{
    $uploadedFile = $_FILES["addItemDescription"]["tmp_name"];
    $descriptionFile = fopen($uploadedFile , "r");
    return fread($descriptionFile, filesize($uploadedFile));
}

/**
 * @return string
 */
function handleUploadedProductImageReturnURL(): string
{
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    $ext = pathinfo($_FILES["addItemImage"]["name"], PATHINFO_EXTENSION);
    $filebase = randomKey();
    $filename = $filebase . "." . $ext;
    $filetype = $_FILES["addItemImage"]["type"];
    $filesize = $_FILES["addItemImage"]["size"];
    $file_destination = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";

    if (!array_key_exists($ext, $allowed)) {
        returnWithError("Creation Error: Wrong File Format!");
    }

    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) {
        returnWithError("Creation Error: File is too big!");
    }

    if (in_array($filetype, $allowed)) {
        if (file_exists($file_destination . $filename)) {
            returnWithError("Creation Error: File already Exists!");
        } else {
            move_uploaded_file($_FILES["addItemImage"]["tmp_name"], $file_destination . $filename);
        }
    } else {
        returnWithError("Creation Error: Fatal Error!");
    }
    return $filebase;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (checkData()) {
        $properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
        $propertiesController = new \PropertiesDepControllerDep($properties_path);
        $dataBaseController = new DataBaseControllerDep(
            $propertiesController->get("db_host"),
            $propertiesController->get("db_user"),
            $propertiesController->get("db_pwd"),
            $propertiesController->get("db_name")
        );
        $newProduct = array(
            "id" => "NULL",
            "name" => $_POST["addItemName"],
            "description" => returnDescriptionFileContent(),
            "price" => $_POST["addItemPrice"],
            "img_url" => handleUploadedProductImageReturnURL(),
            "alcohol_content" => $_POST["addItemAlcoholContent"]
        );
        $dataBaseController->insertProduct("products", $newProduct);
        unset($_POST);
        unset($_FILES);
        header("Location: /BeerCraftShop/public/admin");
    } else {
        returnWithError("Creation Error: Could not create item, check data!");
    }
}

function returnWithError($msg)
{
    session_start();
    $_SESSION['NEW_PRODUCT_ERROR'] = $msg;
    header("Location: /BeerCraftShop/public/admin");
}

/**
 * @return string
 */
function randomKey(): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < 15; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

/**
 * @return bool
 */
function checkData(): bool
{
    return
        isset($_POST["addItemName"]) &
        isset($_POST["addItemAlcoholContent"]) &
        isset($_POST["addItemPrice"]) &
        isset($_FILES["addItemImage"]) &
        isset($_FILES["addItemDescription"]);
}