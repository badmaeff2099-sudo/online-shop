<?php

session_start();

if(isset($_SESSION['userId'])) {

    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);

    $user = $stmt->fetchAll();
    require_once './profile/profile_page.php';
} else {
    header("Location: /login");

}
#$login = $user['user'];
#print_r($login);

#echo "<pre>";
#print_r($user);
#echo "<pre>";
