<?php

namespace Model;

require_once "../Model/Model.php";
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    private function mapToUser(array $userData): self
    {
        $obj = new self();
        $obj->id = $userData['id'];
        $obj->name = $userData['name'];
        $obj->email = $userData['email'];
        $obj->password = $userData['password'];

        return $obj;
    }

 public function getByEmail(string $email): self|null
 {
     $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
     $stmt->execute(['email' => $email]);
     $user = $stmt->fetch();
     if($user === false){
         return null;
     }
     return $this->mapToUser($user);
 }
 public function updateEmailById(string $email, int $userId): void
 {
     $stmt = $this->PDO->prepare("UPDATE users SET email = :email WHERE id =" . $userId);
     $stmt->execute(['email' => $email]);

 }

 public function updateNameById(string $name, int $userId): void
 {
     $stmt = $this->PDO->prepare("UPDATE users SET name = :name WHERE id =" . $userId);
     $stmt->execute(['name' => $name]);
 }

 public function insertUsers(string $name, string $email, string $password): void
 {
// добавление пользователей

     $stmt = $this->PDO->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
     $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать
 }

 public function getByUserId(int $userId): self|null
 {
     $stmt = $this->PDO->prepare("SELECT * FROM users WHERE id = :id");
     $stmt->execute(['id' => $userId]);
     $user = $stmt->fetch();

     if($user === false){
         return null;
     }

     return $this->mapToUser($user);
 }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}

