<?php

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if(!isset($_SESSION['userId'])){
    header("Location: /login");
    exit;
}
function validate(array $data): array
{
    $errors = [];

    if (isset($data['product_id'])) {
        $productId = (int)$data['product_id'];

        $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

        $stmt = $pdo->prepare("SELECT * FROM products WHERE id =:productId");
        $stmt->execute(['productId' => $productId]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать
        $dataId = $stmt->fetch();

        if ($dataId === false) {

            $errors['product_id'] = "Id продукта не найден";
        }
    } else {
        $errors['product_id'] = 'id продукта должен быть обязательно указан';
    }

    if (isset($data['amount'])){
        $amount = (int) $data['amount'];

            if ($amount <= 0) {
                $errors['amount'] = 'Количество продукта не может равняться 0';
            }

            elseif (strlen($amount) > 4) {
            $errors['amount'] = 'некорректное число количества продукта ';
    }
        } else {
        $errors['amount'] = 'Количество продукта должено быть обязательно указано';
    }

    return $errors;
}

$errors = validate($_POST);

if(empty($errors)) {
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
    $userId = $_SESSION['userId'];
    $productId = $_POST['product_id'];
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
    $stmt->execute(['productId' => $productId, 'userId' => $userId]);
    $data = $stmt->fetch();

    if($data === false) {

        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' =>$userId,'productId' => $productId, 'amount' => $amount]);
    } else {

        $amount = $data['amount'] + $amount;
        $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE  user_id = :userId and product_id = :productId");
        $stmt->execute(['amount' => $amount, 'userId' =>$userId, 'productId' => $productId]);
    }

} else {

    require_once './addProduct/add_product_form.php';
}

