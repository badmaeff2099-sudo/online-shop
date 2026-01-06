<?php

$username = $_POST['username'];
$password = $_POST['password'];

$pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $username]);

$user = $stmt->fetch(); // array or false

// user возвращается как массив с id, name, email, password, если он существует

$errors = [];
if ($user === false) {
    $errors['username'] = 'username or password incorrect';
} else {
    $passwordDb = $user['password'];

    if(password_verify($password, $passwordDb)){
        require_once './catalog.php';

    } else {
        $errors['username'] = 'username or password incorrect';
    }
}

require_once './login_form.php';