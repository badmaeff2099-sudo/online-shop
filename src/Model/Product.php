<?php
//namespace Model;
//
//require_once "../Model/Model.php";
//
//class Product extends Model
//{
//    public function getByProductIdUserId(int $productId, int $userId): array|false
//    {
//        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id = :userId");
//        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
//        return $stmt->fetch();
//
//    }
//
//    public function insertUserProduct(int $userId, int $productId, $amount): void
//    {
//        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
//        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
//    }
//
//    public function updateUserProduct($amount, int $userId, int $productId): void
//    {
//        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE  user_id = :userId and product_id = :productId");
//        $stmt->execute(['amount' => $amount, 'userId' => $userId, 'productId' => $productId]);
//    }
//
//    public function getOneById(int $productId): array|false
//    {
//        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id =:productId");
//        $stmt->execute(['productId' => $productId]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать
//        return $stmt->fetch();
//    }
//
//    public function deleteUserProduct($userId, $productId): void
//    {
//        $stmt = $this->PDO->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
//        $stmt->execute([':user_id' => $userId, ':product_id' => $productId]);
//    }
//
//}

namespace Model;

use PDO;

require_once "../Model/Model.php";

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $image_url;

    // 🔹 универсальный маппер
    private function mapToProduct(array $productData): self
    {
        $obj = new self();
        $obj->id = $productData['id'];
        $obj->name = $productData['name'];
        $obj->description = $productData['description'];
        $obj->price = $productData['price'];
        $obj->image_url = $productData['image_url'];

        return $obj;
    }

    // 🔹 получение продукта по id
    public function getOneById(int $productId): self|null
    {
        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id = :productId");
        $stmt->execute(['productId' => $productId]);

        $product = $stmt->fetch();

        if ($product === false) {
            return null;
        }

        return $this->mapToProduct($product);
    }

    // 🔹 связь user-product (можно тоже через объект, но зависит от задачи)



    public function getCatalog(): array
    {
        // если пользователь найден, выдаем каталог
        $stmt = $this->PDO->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }

    public function getProductsByProductId(int $productId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id = :productId");

        $stmt->execute(['productId' => $productId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 🔹 геттеры
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}