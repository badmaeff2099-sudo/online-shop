<?php

namespace Model;

//require_once "../Model/Model.php";
use PDO;

class Cart extends Model
{
    public function getAllProductsByUserId(int $userId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE user_id = :userId ORDER BY product_id ASC");

        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByProductId(int $productId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id = :productId");

        $stmt->execute(['productId' => $productId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteByUserId(int $userId)
    {
         $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :userId");
         $stmt->execute(['userId' => $userId]);
    }
}