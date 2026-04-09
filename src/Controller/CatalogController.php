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


            $products = $this->productModel->getCatalog(); // получение каталога всех продуктов


            require_once '../Views/catalog_page.php';
        } else {

            header("Location: /login");
        }

    }

}