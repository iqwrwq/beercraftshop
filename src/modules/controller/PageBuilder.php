<?php


namespace modules\controller;


class PageBuilder
{
    protected $pages_root;

    public function __construct()
    {
        $this->pages_root = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages";
    }

    /**
     * @param string $title
     * @param Page $page
     */
    protected function build(string $title, Page $page){
        include_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/meta.php";
        echo "<title>$title</title>";
        include_once $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "BeerCraftShop/src/pages/public/partials/title.php";
        include_once $page->getSelf();
    }
}