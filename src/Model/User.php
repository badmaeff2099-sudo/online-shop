<?php

require_once "../Model/Model.php";
class User extends Model
{

 public function getByEmail(string $email): array|false
 {
     $stmt = $this->PDO->prepare("SELECT * FROM users WHERE email = :email");
     $stmt->execute(['email' => $email]);

     $result = $stmt->fetch();

     return $result;
 }
 public function updateEmailById(string $email, int $userId)
 {
     $stmt = $this->PDO->prepare("UPDATE users SET email = :email WHERE id =" . $userId);
     $stmt->execute(['email' => $email]);

 }

 public function updateNameById(string $name, int $userId)
 {
     $stmt = $this->PDO->prepare("UPDATE users SET name = :name WHERE id =" . $userId);
     $stmt->execute(['name' => $name]);
 }

 public function insertUsers(string $name, string $email, string $password)
 {
// добавление пользователей

     $stmt = $this->PDO->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
     $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать
 }

 public function getById(int $userId)
 {
     $stmt = $this->PDO->query('SELECT * FROM users WHERE id = ' . $userId);
     $result = $stmt->fetch();
     return $result;
 }
}

