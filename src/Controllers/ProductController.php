<?php

class ProductController
{
    public function getProduct()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        }
        require_once '../Views/add_product_form.php';
    }

    public function addProduct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }


        $errors = $this->validate($_POST);

        if (empty($errors)) {
            $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $userId = $_SESSION['userId'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];

            require_once '../Model/Product.php';
            $productModel = new Product();
            $data = $productModel->getByProductIdUserId($productId, $userId);


            if ($data === false) {

                require_once '../Model/Product.php';
                $productModel = new Product();
                $productModel->insertUserProduct($userId, $productId, $amount);

            } else {

                $amount = $data['amount'] + $amount;
                require_once '../Model/Product.php';
                $productModel = new Product();
                $productModel->updateUserProduct($amount, $userId, $productId);

            }

        } else {

            require_once '../Views/add_product_form.php';
        }

    }

    private function validate(array $data): array
    {
        $errors = [];

        if (isset($data['product_id'])) {
            $productId = (int)$data['product_id'];

            require_once '../Model/Product.php';
            $productModel = new Product();
            $dataId = $productModel->getByProductId($productId);

            if ($dataId === false) {

                $errors['product_id'] = "Id продукта не найден";
            }
        } else {
            $errors['product_id'] = 'id продукта должен быть обязательно указан';
        }

        if (isset($data['amount'])) {
            $amount = (int)$data['amount'];

            if ($amount <= 0) {
                $errors['amount'] = 'Количество продукта не может равняться 0';
            } elseif (strlen($amount) > 4) {
                $errors['amount'] = 'некорректное число количества продукта';
            }
        } else {
            $errors['amount'] = 'Количество продукта должено быть обязательно указано';
        }

        return $errors;
    }

}