<?php

require_once "../Model/Model.php";

class Catalog extends Model
{
    public function getCatalog()
    {
       // если пользователь найден, выдаем каталог
        $stmt = $this->PDO->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        return $products;
    }
}