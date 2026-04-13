<?php

namespace Controller;

use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Model\Product;


class OrderController
{
    private UserProduct $userProductModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
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

        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {

            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {

                $product = $this->productModel->getOneById($orderProduct->getProductId());

                // если товар не найден — пропускаем
                if ($product === null) {
                    continue;
                }

                $totalOne = $orderProduct->getAmount() * $product->getPrice();

                $newOrderProducts[] = [
                    'id' => $orderProduct->getId(),
                    'product_id' => $orderProduct->getProductId(),
                    'amount' => $orderProduct->getAmount(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'totalSumOneProduct' => $totalOne
                ];

                $sum += $totalOne;
            }

            $newUserOrders[] = [
                'order' => $userOrder,
                'total' => $sum,
                'products' => $newOrderProducts
            ];
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
            $orderId = $orderModel->create($contactName, $contactPhone, $comment, $address, $userId);

            $userProductModel = new UserProduct();
            $userProducts = $userProductModel->getAllProductsByUserId($userId); //cart

            $orderProduct = new OrderProduct();

            foreach ($userProducts as $userProduct) {
                $orderProduct->create( $orderId, $userProduct->getProductId(), $userProduct->getAmount());
            }

            $userProductModel->deleteByUserId($userId);

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