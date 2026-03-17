<?php

namespace Model;
class Order extends Model{

    public function create(string $contactName, string $contactPhone, string $comment, string $address, int $userId)
    {
        $stmt = $this->PDO->prepare(
            "INSERT INTO orders(contact_name, contact_phone, comment, address, user_id) 
                   VALUES (:name, :phone, :comment, :address, :user_id) RETURNING id"
        );

        $stmt->execute([
            'name' => $contactName,
            'phone' => $contactPhone,
            'comment' => $comment,
            'address' => $address,
            'user_id' => $userId
        ]);

        $data = $stmt->fetch();
        return $data['id'];
    }
}

