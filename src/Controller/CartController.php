<?php
namespace Controller;
use Model\Cart;

class CartController
{

    public function getCart()
    {

        session_start();

        if (isset($_SESSION['userId'])) {

           // require_once '../Model/Cart.php';
            $cartModel = new Cart();

            $userId = $_SESSION['userId'];

            $userProducts = $cartModel->getCart($userId); // получение всех продуктов корзины

            $products = [];
            foreach ($userProducts as $userProduct){
                $productId = $userProduct['product_id'];

                $product = $cartModel->getProductsByProductId($productId);

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

