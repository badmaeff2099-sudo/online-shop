<?php


$pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

$stmt = $pdo->query('SELECT * FROM products');

$products = $stmt->fetchAll();

#print_r($products);


require_once './catalog_page.php';