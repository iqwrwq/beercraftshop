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
    public function init($table_data, $table_name)
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
     * @return true|false
     */
    private function goodToGo()
    {
        return $this->connection->select_db($this->db_name);
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
        if (isset($_FILES["new_product_image"]) && $_FILES["photo"]["error"] == 0) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $ext = pathinfo($_FILES["new_product_image"]["name"], PATHINFO_EXTENSION);
            $filebase = randomKey();
            $filename = $filebase . "." . $ext;
            $filetype = $_FILES["new_product_image"]["type"];
            $filesize = $_FILES["new_product_image"]["size"];
            $file_destination = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/public/resources/images/products/";

            if (!array_key_exists($ext, $allowed)) {
                session_start();
                $_SESSION['NEW_PRODUCT_ERROR'] = "Creation Error: Invalid file type!";
                header("Location: /BeerCraftShop/public/admin");
            }

            $maxsize = 5 * 1024 * 1024;
            if ($filesize > $maxsize) {
                session_start();
                $_SESSION['NEW_PRODUCT_ERROR'] = "Creation Error: File is too big!";
                header("Location: /BeerCraftShop/public/admin");
            }

            if (in_array($filetype, $allowed)) {
                if (file_exists($file_destination . $filename)) {
                    echo $filename . " is already exists.";
                } else {
                    move_uploaded_file($_FILES["new_product_image"]["tmp_name"], $file_destination . $filename);
                    echo "Your file was uploaded successfully.";
                }
            } else {
                echo "Error: There was a problem uploading your file. Please try again.";
            }
        }
        unset($_POST);
        unset($_FILES);
        header("Location: /BeerCraftShop/public/admin");
    }
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


function checkData(): bool
{
    return
        isset($_POST["new_product_image"]) &
        isset($_POST["new_product_name"]) &
        isset($_POST["new_product_alcoholContent"]) &
        isset($_POST["new_product_price"]) &
        isset($_POST["new_product_description"]);
}