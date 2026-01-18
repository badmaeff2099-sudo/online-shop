<?php
$errors = [];

// проверка наличия переменной

function validate(array $data): array
{
    $errors = [];
    if(!isset($data['username'])){
        $errors['username'] = "Поле Username обязательно для заполнения!";
    }

    if(!isset($data['password'])){
        $errors['password'] = "Поле Password обязательно для заполнения!";
    }
    return $errors;
}

$errors = validate($_POST);

if(empty($errors)){

    $username = $_POST['username'];
    $password = $_POST['password'];


    $pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $username]);
    $user = $stmt->fetch(); // array or false


    if(!empty($user)) {
        $passwordDb = $user['password'];

        if (password_verify($password, $passwordDb)) {

            // успешный вход через сессии
            session_start();
            $_SESSION['userId'] = $user['id'];

            // успешный вход через куки
            //setcookie('user_id', $user['id']);
            header("Location: /catalog");

        } else {
            $errors['username'] = 'username or password incorrect';
        }
    }else {
            $errors['username'] = 'Пользователя с таким логином не существует.';
        }
    }


require_once './login_form.php';

