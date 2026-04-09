<?php

namespace Model;
class Order extends Model
{
    private int $id;
    private string $contact_name;
    private string $contact_phone;
    private string $comment;
    private int $user_id;
    private string $address;

    private function mapToOrder(array $resultData): self
    {
        $obj = new self();
        $obj->id = $resultData['id'];
        $obj->contact_name = $resultData['contact_name'];
        $obj->contact_phone = $resultData['contact_phone'];
        $obj->comment = $resultData['comment'];
        $obj->user_id = $resultData['user_id'];
        $obj->address = $resultData['address'];

        return $obj;
    }


    public function create(string $contactName, string $contactPhone, string $comment, string $address, int $userId)
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO orders(contact_name, contact_phone, comment, address, user_id) 
                   VALUES (:name, :phone, :comment, :address, :user_id) RETURNING id"
        );

        $stmt->execute(['name' => $contactName, 'phone' => $contactPhone, 'comment' => $comment, 'address' => $address, 'user_id' => $userId]);

        $data = $stmt->fetch();
       return $data['id'];
    }

    public function getAllByUserId($userId): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);
        $results = $stmt->fetchAll();

        $products = [];

        foreach ($results as $result) {
            $products[] = $this->mapToOrder($result);
        }

        return $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

}

