<?php

class Catalog
{
    public function getCatalog()
    {
        $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
// если пользователь найден, выдаем каталог
        $stmt = $pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        return $products;
    }
}