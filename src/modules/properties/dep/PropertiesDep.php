<?php
/**
 * @authors  Sajad, Arthur, Simon, Tristan
 */

class PropertiesDep
{
    protected $properties_path;

    public function __construct($properties_path)
    {
        $this->properties_path = $properties_path;
        if (!file_exists($properties_path)) fopen($properties_path, "w");
    }

    /**
     * @return array
     */
    public function read():array
    {
        $strJsonFileContents = file_get_contents($this->properties_path);
        return json_decode($strJsonFileContents, true);
    }

    /**
     * @param $field
     * @return false|mixed
     */
    public function get($field)
    {
        $data = $this->read();
        return array_key_exists($field,$data) ? $data[$field] : false;
    }

    /**
     * @param array $data
     * @return true|false
     */
    public function write(array $data):bool
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents($this->properties_path, $json) ? true : false;
    }

    public function change($key, $value){
        $json = file_get_contents($this->properties_path);
        $data = json_decode($json, true);
        $data[$key] = $value;
        $fresh_json = json_encode($data);
        file_put_contents($this->properties_path, $fresh_json);
    }


}