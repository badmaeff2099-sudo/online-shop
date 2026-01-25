<?php

session_start();

if (isset($_SESSION['userId'])) {

    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
// если пользователь найден, выдаем каталог
    $stmt = $pdo->query('SELECT * FROM products');
    $products = $stmt->fetchAll();
    require_once './catalog/catalog_page.php';
} else {

    header("Location: /login");
}

?>


<!DOCTYPE html>
<html lang="ru">
<head>

</head>
<body>
<div class="profile-actions">
    <button class="edit-profile-btn">
        <i class="fas fa-edit"></i>
        <a href="/profile">Мой профиль</a>
    </button>
</div>
</body>
</html>
