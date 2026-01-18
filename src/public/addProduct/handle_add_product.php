<?php

if (!isset($_COOKIE['user_id'])){
    header("Location: /login_form.php");
}
//$errors = [];
function validate(array $data): array
{
    $errors = [];

    // объявление и валидация данных

    if (empty($data['product_id'])) {
        $errors['product_id'] = 'ID продукта должно быть заполнено';
    } elseif (!ctype_digit($data['product_id'])) {
        $errors['product_id'] = 'ID продукта некорректное';
    }

    if (empty($data['amount'])) {
        $errors['amount'] = 'Количество должно быть заполнено';
    } elseif (!ctype_digit($data['amount'])) {
        $errors['amount'] = 'Количество продукта некорректное';
    }

     return $errors;
}

$errors = validate($_POST);

// внесение в БД, если нет ошибок

if (empty($errors)){
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];
$user_id = $_COOKIE['user_id'];

    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

// добавление ID и количества продукта в БД

    $stmt = $pdo->prepare("INSERT INTO user_products (product_id, amount) VALUES (:product_id, :amount)");
    $stmt->execute(['product_id'=> $product_id, 'amount'=> $amount]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать


    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->execute(['user_id'=> $user_id]);

    $result = $stmt->fetch();
    print_r($result);
}

require_once './add_product_form.php.php';
?>
