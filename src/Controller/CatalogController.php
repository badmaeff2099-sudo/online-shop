<?php
namespace Controller;
use Model\Catalog;

class CatalogController
{
    public function getCatalog()
    {

        session_start();

        if (isset($_SESSION['userId'])) {

            //require_once '../Model/Catalog.php';
            $catalogModel = new Catalog();

            $catalogModel->getCatalog(); // получение каталога всех продуктов

            $products = $catalogModel->getCatalog();
            require_once '../Views/catalog_page.php';
        } else {

            header("Location: /login");
        }

    }

}