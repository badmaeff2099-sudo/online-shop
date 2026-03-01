<?php

require_once "../Model/Model.php";
class Cart extends Model
{
    public function getCart($userId)
    {
        // если пользователь найден, выдаем страницу корзины
        $stmt = $this->PDO->query("SELECT * FROM user_products WHERE user_id = {$userId}");
        $userProducts = $stmt->fetchAll();
        return $userProducts;
    }

    public function getProductsByProductId($productId)
    {
        $stmt = $this->PDO->query("SELECT * FROM products WHERE id = {$productId}");
        $userProducts = $stmt->fetch();
        return $userProducts;
    }
}