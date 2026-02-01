<?php

 function validate(array $data): array
 {
     $errors = [];

     // объявление и валидация данных

     if (isset($data['name'])) {
         $name = $data['name'];
         if (strlen($name) < 2) {
             $errors['name'] = "Имя должно быть больше 2 символов";
         }
     } else {
         $errors['name'] = "Имя должно быть заполнено";
     }

     if (isset($data['email'])) {
         $email = $data['email'];
         if (strlen($email) < 2) {
             $errors['email'] = "Почта должна быть больше 2 символов";
         } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $errors['email'] = "email некорректный";
         } else {
             // соединение с БД

             $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
             $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
             $stmt->execute(['email' => $email]);
             $count = $stmt->fetchColumn();
             if ($count > 0) {
                 $errors['email'] = "Этот Email уже зарегистрирован";
             }
         }
     } else {
         $errors['email'] = "Почта должна быть заполнена";
     }

     //  проверка совпадения паролей

     if (isset($data['psw'])) {
         $password = $data['psw'];
         if (strlen($password) < 2) {
             $errors['psw'] = 'пароль должен быть больше 2';
         }
         $passwordRep = $data["psw-rep"];
         if ($password !== $passwordRep) {
             $errors['psw-rep'] = 'пароли не совпадают';
         }
     } else {
         $errors['psw'] = 'Пароль должен быть заполнен';
     }



     return $errors;
 }

     $errors = validate($_POST);

 // внесение в БД, если нет ошибок

     if (empty($errors)){
         $name = $_POST['name'];
         $email = $_POST['email'];
         $password = $_POST['psw'];
         $passwordRep = $_POST['psw-rep'];
         $password = password_hash($password, PASSWORD_DEFAULT);

         $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

// добавление пользователей

$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name'=> $name, 'email'=> $email, 'password' => $password]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать


$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email"); // для вывода данных зарегистрированного пользователя на экран
    $stmt->execute(['email'=> $email]);

     $result = $stmt->fetch(); // находится массив с данными пользователя: имя, почта, пароль, повторный пароль
     print_r($result);
}

require_once './registration/registration_form.php';
?>



