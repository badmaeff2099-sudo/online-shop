<?php

class Product
{
public function getByProductIdUserId(int $productId, int $userId)
{
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
    $stmt->execute(['productId' => $productId, 'userId' => $userId]);
    $result = $stmt->fetch();
    return $result;
}

public function insertUserProduct(int $userId, int $productId, $amount)
{
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
    $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
}

public function updateUserProduct($amount, int $userId, int $productId)
{
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE  user_id = :userId and product_id = :productId");
    $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
}

public function getByProductId(int $productId)
{
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id =:productId");
    $stmt->execute(['productId' => $productId]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать
    $result = $stmt->fetch();
    return $result;
}
}