<?php
namespace Controller;
use Model\Product;

class CatalogController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();

    }
    public function getCatalog()
    {


        session_start();

        if (isset($_SESSION['userId'])) {


            $this->productModel->getCatalog(); // получение каталога всех продуктов

            $products = $this->productModel->getCatalog();
            require_once '../Views/catalog_page.php';
        } else {

            header("Location: /login");
        }

    }

}