<?php

#print_r($_GET);

// $name = $_POST['name']; переместил на 14ю строчку данный код для проверки на иссет
// $email = $_POST['email']; переместил ниже на проверку на иссет
// $password = $_POST['psw']; также переместил ниже на проверку наличия
// $passwordRep = $_POST['psw-rep']; также переместил ниже на проверку наличия


$errors = [];

if(isset($_POST['name'])){
    $name = $_POST['name'];

    if (strlen($name) < 2 ){
        $errors['name'] = 'имя должно быть больше 2';
    }
} else {
    $errors['name'] = 'Имя должно быть заполнено';
}


if(isset($_POST['email'])) {
    $email = $_POST['email'];

    if (strlen($email) < 2) {
        $errors['email'] = 'почта должна быть больше 2';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'email некорректный ';
    }
} else {
        $errors['email'] = 'Почта должна быть заполнена';
    }


if(isset($_POST['psw'])) {
    $password = $_POST['psw'];

    if (strlen($password) < 2) {
        $errors['psw'] = 'пароль должен быть больше 2';
    }
    } else {
        $errors['psw'] = 'Пароль должен быть заполнен';
    }


if(isset($_POST['psw-rep'])) {
$passwordRep = $_POST['psw-rep'];

if (strlen($passwordRep) < 2 ){
    $errors['psw-rep'] = 'повторный пароль должен быть больше 2';
}
} else {
    $errors['psw-rep'] = 'Повторный пароль должен быть заполнен';
}


if($password !== $passwordRep){

    $errors['psw-rep'] = 'пароли не совпадают';
}

if (empty($errors)){
    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name'=> $name, 'email'=> $email, 'password' => $password]); #здесь под капотом выполняется метод экранирования против sql инъекции, поэтому метод ниже можно убрать или закомментировать


    #$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email'=> $email]);
    $data = $stmt->fetch();
    print_r($data);
}

#else {
 #   print_r($errors);
#}

require_once './registration_form.phtml';
?>




