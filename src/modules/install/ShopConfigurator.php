<?php


namespace modules\install;


class ShopConfigurator
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $fromData
     * @return array
     */
    public function drainDataBaseLogin(array $fromData): array
    {
        return array(
            "host" => $fromData["host_input"],
            "user" => $fromData["db_user_input"],
            "pwd" => $fromData["db_pwd_input"]
        );
    }

    public function drainNewAdminUser(array $fromData){

    }
}