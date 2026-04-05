<?php

namespace Model;

//require_once "../Model/Model.php";
use PDO;

class UserProduct extends Model
{

    private int $id;
    private int $user_id;
    private int $product_id;
    private int $amount;

    private function mapToUserProduct(array $userData): self
    {
        $obj = new self();
        $obj->id = $userData['id'];
        $obj->user_id = $userData['user_id'];
        $obj->product_id = $userData['product_id'];
        $obj->amount = $userData['amount'];

        return $obj;
    }

    public function getAllProductsByUserId(int $userId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE user_id = :userId ORDER BY product_id ASC");

        $stmt->execute(['userId' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByUserId(int $userId): void
    {
         $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :userId");
         $stmt->execute(['userId' => $userId]);
    }

    public function getByProductIdUserId(int $productId, int $userId): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);

        $result = $stmt->fetch();
        if($result === false){
            return null;
        }
        return $this->mapToUserProduct($result);
    }

    public function insertUserProduct(int $userId, int $productId, $amount): void
    {
        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) 
            VALUES (:userId, :productId, :amount)");

        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateUserProduct($amount, int $userId, int $productId): void
    {
        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :userId AND product_id = :productId");

        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
    }

    public function deleteUserProduct($userId, $productId): void
    {
        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");

        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


}