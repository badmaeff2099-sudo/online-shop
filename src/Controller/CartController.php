<?php
namespace Controller;

use Model\UserProduct;
use Model\Product;


class CartController
{

    private Product $productModel;
    private UserProduct $userProductModel;


    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();

    }

    public function getCart()
    {

        session_start();

        if (isset($_SESSION['userId'])) {



            $userId = $_SESSION['userId'];

            $userProducts = $this->userProductModel->getAllProductsByUserId($userId); // получение всех продуктов корзины

            $products = [];
            foreach ($userProducts as $userProduct){
                $productId = $userProduct['product_id'];

                $product = $this->productModel->getProductsByProductId($productId);

                $product['amount'] = $userProduct['amount'];

                $product['totalPrice'] = $product['amount'] * $product['price'];
                $products[] = $product;
            }

            require_once '../Views/cart.php';

} else {

            header("Location: /login");
        }

    }

}

