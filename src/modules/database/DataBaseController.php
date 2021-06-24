<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

namespace BeerCraftShop\src\modules\database;

require_once __DIR__ . DIRECTORY_SEPARATOR . "DataBase.php";
require_once __DIR__ . DIRECTORY_SEPARATOR . "QueryController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/modules/properties/PropertiesController.php";

use mysqli_result;

class DataBaseController extends DataBase
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
            $queryController = new QueryController();
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
        $queryController = new QueryController();
        $sql = $queryController->dataToInsertSql($table, $data);
        $this->connection->select_db($this->db_name);
        $this->connection->query($sql);
    }

    public function removeProduct($table, $id){
        $queryController = new QueryController();
        $sql = $queryController->removeByIdSql($table, $id);
        $this->connection->select_db($this->db_name);
        $this->connection->query($sql);
    }

    public function updateProduct($table, $data){
        $queryController = new QueryController();
        $sql = $queryController->updateByIdSql($table, $data);
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
    $properties_path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/tmp/properties.json";
    $propertiesController = new \PropertiesController($properties_path);
    $dataBaseController = new DataBaseController(
        $propertiesController->get("db_host"),
        $propertiesController->get("db_user"),
        $propertiesController->get("db_pwd"),
        $propertiesController->get("db_name")
    );
    if (newItemPropertiesAreSet()) {
        createItem($dataBaseController);
    } elseif (isset($_POST["change"])) {
        if (isset($_FILES["changeFormImageField"])){
            $fileRoot = $file_destination = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";
            $oldFile = $fileRoot . $_POST['oldImageField'];
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $ext = pathinfo($_FILES["changeFormImageField"]["name"], PATHINFO_EXTENSION);
            $fileType = $_FILES["changeFormImageField"]["type"];
            $fileBase = randomKey();
            $filename = $fileBase . "." . $ext;
            if (in_array($fileType, $allowed)) {
                if (file_exists($file_destination . $filename)) {
                    returnWithError("Creation Error: File already Exists!");
                } else {
                    $img_url = $fileBase;
                    unlink($oldFile);
                    move_uploaded_file($_FILES["changeFormImageField"]["tmp_name"], $file_destination . $filename);
                }
            } else {
                returnWithError("Creation Error: Fatal Error!");
            }
        }
        $data = array(
          "id" => $_POST["oldIdField"],
            "name" => $_POST["changeFormNameField"],
            "description" => $_POST["changeFormDescField"],
            "price" => $_POST["changeFormPriceField"],
            "img_url" => $img_url,
            "alcohol_content" => $_POST["changeFormAlcoholContentField"],
        );
        $dataBaseController->updateProduct("products", $data);
    } elseif (isset($_POST["delete"])) {
        $dataBaseController->removeProduct("products", $_POST["oldIdField"]);
        $fileRoot = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";
        $e = unlink($fileRoot . $_POST['changeFormImageField'] . ".jpg");
    } else {
        returnWithError("Creation Error: Could not create item, check data!");
    }
    unset($_POST);
    unset($_FILES);
    header("Location: /BeerCraftShop/public/admin");
}

function createItem(DataBaseController $dataBaseController)
{

    $newProduct = array(
        "id" => "NULL",
        "name" => $_POST["addItemName"],
        "description" => returnDescriptionFileContent(),
        "price" => $_POST["addItemPrice"],
        "img_url" => handleUploadedProductImageReturnURL(),
        "alcohol_content" => $_POST["addItemAlcoholContent"]
    );
    $dataBaseController->insertProduct("products", $newProduct);
}

/**
 * @return string
 */
function returnDescriptionFileContent(): string
{
    $uploadedFile = $_FILES["addItemDescription"]["tmp_name"];
    $descriptionFile = fopen($uploadedFile, "r");
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
function newItemPropertiesAreSet(): bool
{
    return
        isset($_POST["addItemName"]) &
        isset($_POST["addItemAlcoholContent"]) &
        isset($_POST["addItemPrice"]) &
        isset($_FILES["addItemImage"]) &
        isset($_FILES["addItemDescription"]);
}