<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "Properties.php";

class PropertiesController extends Properties
{
    public function __construct($properties_path)
    {
        parent::__construct($properties_path);
    }

    /**
     * @param $data
     * @return bool
     */
    public function init($data): bool
    {
        $this->write($data);
        return self::check($this->properties_path);
    }

    /**
     * @param $path
     * @return bool
     */
    public static function check($path): bool
    {
        if (!file_exists($path)) return false;
        $strJsonFileContents = file_get_contents($path);
        $data = json_decode($strJsonFileContents, true);
        return file_exists($path) && isset($data["db_host"]) && isset($data["db_user"]) && isset($data["db_pwd"]) && isset($data["db_name"]);
    }

    /**
     * @param $path
     * @return array|false
     */
    public static function getContent($path)
    {
        if (self::check($path)) {
            $strJsonFileContents = file_get_contents($path);
            return json_decode($strJsonFileContents, true);
        }
        return false;
    }


}