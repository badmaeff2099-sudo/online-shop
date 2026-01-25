<?php

session_start();

if(isset($_SESSION['userId'])) {
$userId = $_SESSION['userId'];
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->query('SELECT * FROM users WHERE id = ' . $userId);

    $user = $stmt->fetch();
    require_once './profile/profile_page.php';
} else {
    header("Location: /login");

}
#$login = $user['user'];
#print_r($login);

#echo "<pre>";
#print_r($user);
#echo "<pre>";
