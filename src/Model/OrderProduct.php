<?php

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;

    private function mapToOrderProduct(array $orderData): self
    {
        $obj = new self();
        $obj->id = $orderData['id'];
        $obj->orderId = $orderData['order_id'];
        $obj->productId = $orderData['product_id'];
        $obj->amount = $orderData['amount'];

        return $obj;
    }
    public function create(int $orderId, int $productId, int $amount): void
    {
        $stmt = $this->PDO->prepare("INSERT INTO order_products(order_id, product_id, amount) VALUES(:orderId, :productId, :amount)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function getAllByOrderId(int $orderId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM order_products WHERE order_id =:orderId");
        $stmt->execute(['orderId' => $orderId]);
        $results = $stmt->fetchAll();

        $products = [];

        foreach ($results as $result) {
            $products[] = $this->mapToOrderProduct($result);
        }

        return $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}
