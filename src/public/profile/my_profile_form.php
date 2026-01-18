<?php
if (!isset($_COOKIE['user_id'])){
    header("Location: /login_form.php");
}

$pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

$stmt = $pdo->query('SELECT * FROM users');

$user = $stmt->fetch();
$login = $user['user'];
print_r($login);

echo "<pre>";
print_r($user);
echo "<pre>";



