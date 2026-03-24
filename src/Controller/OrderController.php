<?php

namespace Controller;

use Model\Cart;
use Model\Order;
use Model\OrderProduct;
use Model\Product;


class OrderController
{
    private Cart $cartModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
    }

    public function getAllOrders()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['userId'];


        $userOrders = $this->orderModel->getAllByUserId($userId);

//        $userOrders = [
//           [
//            'id' => 1,
//            'user_id' => 1,
//            'contact_name' => 'test',
//            'contact_phone' => '12345',
//            'comment' => null
//           ],
//           [
//            'id' => 2,
//            'user_id' => 1,
//            'contact_name' => 'test',
//            'contact_phone' => '12345',
//            'comment' => null
//           ]
//        ];


        $newUserOrders = [];
        foreach ($userOrders as $userOrder) {

//          $userOrder = [
////          'id' => 1,
//            'user_id' => 1,
//            'contact_name' => 'test',
//            'contact_phone' => '12345',
//            'comment' => null
//           ];


            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder['id']);

//            $orderProducts = [
//              [
////                'id'=>1,
////                'order_id' => 1,
////                'product_id' => 10.
////                'amount' => 100,
////            ],
//              [
////                'id'=>2,
////                'order_id' => 2,
////                'product_id' => 11.
////                'amount' => 200,
////            ],
////          ];

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {

//            $orderProduct = [
//                'id'=>1,
//                'order_id' => 1,
//                'product_id' => 10.
//                'amount' => 100,
//            ]

                $product = $this->productModel->getOneById($orderProduct['product_id']);

//            $product = [
////                'id'=>10,
////                'name' => Macbook,
////                'price' => 256000.
////                'image_url' => https/.,
////            ]


                $orderProduct['name'] = $product['name'];
                $orderProduct['price'] = $product['price'];
                $orderProduct['totalSumOneProduct'] = $orderProduct['amount'] * $orderProduct['price'];

///             $orderProduct = [
////                'id'=>1,
////                'order_id' => 1,
////                'product_id' => 10.
////                'amount' => 100,
///                 'name' => Macbook,
////                'price' => 256000.
///                 'totalSumOneProduct' => $orderProduct['amount] * $product['price],
////            ]

                $newOrderProducts[] = $orderProduct;
                $sum = $sum + $orderProduct['totalSumOneProduct'];
            }

            $userOrder['total'] = $sum;
            $userOrder['products'] = $newOrderProducts;

            $newUserOrders[] = $userOrder;
            //  return $newOrderProducts;
        }

        require_once '../Views/user_orders.php';
    }


    public function getCheckoutForm(): void
    {
        require_once "./../Views/order_form.php";
    }

    public function handleCheckout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        [$errors, $cleanData] = $this->validate($_POST);

        if (empty($errors)) {

            $contactName = $cleanData['contact_name'];
            $contactPhone = $cleanData['contact_phone'];
            $comment = $cleanData['comment'];
            $address = $cleanData['address'];
            $userId = $_SESSION['userId'];

            $orderModel = new Order();
            $orderId = $orderModel->create(
                $contactName,
                $contactPhone,
                $comment,
                $address,
                $userId
            );

            $cartModel = new Cart();
            $userProducts = $cartModel->getAllProductsByUserId($userId);

            $orderProduct = new OrderProduct();

            foreach ($userProducts as $userProduct) {
                $orderProduct->create(
                    $orderId,
                    $userProduct['product_id'],
                    $userProduct['amount']
                );
            }

            $cartModel->deleteByUserId($userId);

            $_SESSION['success'] = "Заказ успешно оформлен";
            header("Location: /cart");
            exit;

        } else {
            require_once "./../Views/order_form.php";
        }
    }

    private function validate(array $data): array
    {
        $errors = [];
        $clean = [];

        // --- NAME ---
        $name = trim($data['contact_name'] ?? '');
        $name = preg_replace('/\s+/u', ' ', $name);

        if ($name === '') {
            $errors['contact_name'] = "Имя должно быть заполнено";
        } elseif (mb_strlen($name) < 2) {
            $errors['contact_name'] = "Имя должно быть не короче 2 символов";
        } elseif (mb_strlen($name) > 50) {
            $errors['contact_name'] = "Имя слишком длинное";
        } elseif (!preg_match('/^[\p{L}\s\-]+$/u', $name)) {
            $errors['contact_name'] = "Только буквы, пробел и дефис";
        } elseif (preg_match('/[\s\-]{2,}/u', $name)) {
            $errors['contact_name'] = "Нельзя использовать подряд пробелы или дефисы";
        } elseif (preg_match('/^[\s\-]|[\s\-]$/u', $name)) {
            $errors['contact_name'] = "Имя не должно начинаться или заканчиваться пробелом или дефисом";
        } else {
            $clean['contact_name'] = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
        }

        // --- PHONE ---
        $phone = trim($data['contact_phone'] ?? '');

        if ($phone === '') {
            $errors['contact_phone'] = "Номер телефона должен быть заполнен";
        } else {

            // ❗ Проверка: только цифры, пробелы, +, -, ()
            if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $phone)) {
                $errors['contact_phone'] = "Телефон не должен содержать буквы";
            } else {

                // очистка после проверки
                $phone = preg_replace('/[^0-9+]/', '', $phone);
                $phone = preg_replace('/(?!^)\+/', '', $phone);

                if (!preg_match('/^\+?[0-9]{6,15}$/', $phone)) {
                    $errors['contact_phone'] = "Телефон некорректный";
                } else {
                    $clean['contact_phone'] = $phone;
                }
            }
        }

        // --- ADDRESS ---
        $address = trim($data['address'] ?? '');

        if ($address === '') {
            $errors['address'] = 'Адрес должен быть заполнен';
        } elseif (mb_strlen($address) < 10) {
            $errors['address'] = 'Слишком короткий адрес';
        } else {
            $clean['address'] = $address;
        }

        // --- COMMENT ---
        $comment = trim($data['comment'] ?? '');

        if ($comment !== '' && mb_strlen($comment) > 255) {
            $errors['comment'] = 'Слишком длинный комментарий';
        } else {
            $clean['comment'] = $comment;
        }

        return [$errors, $clean];
    }

}