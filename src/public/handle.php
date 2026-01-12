<?php


function validate(array $data): array
{
    $errors = [];

    // NAME
    if (isset($data['name'])) {
        $name = trim($data['name']);
        if (strlen($name) < 2) {
            $errors['name'] = 'Имя должно быть больше 2 символов';
        }
    } else {
        $errors['name'] = 'Имя должно быть заполнено';
    }

    // EMAIL
    if (isset($data['email'])) {
        $email = trim($data['email']);

        if (strlen($email) < 2) {
            $errors['email'] = 'Почта должна быть больше 2 символов';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email некорректный';
        } else {
            // Проверка email в БД
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetchColumn() > 0) {
                $errors['email'] = 'Этот Email уже зарегистрирован';
            }
        }
    } else {
        $errors['email'] = 'Почта должна быть заполнена';
    }

    // PASSWORD
    if (isset($data['psw'])) {
        $password = $data['psw'];

        if (strlen($password) < 2) {
            $errors['psw'] = 'Пароль должен быть больше 2 символов';
        }

        if (!isset($data['psw-rep']) || $password !== $data['psw-rep']) {
            $errors['psw-rep'] = 'Пароли не совпадают';
        }
    } else {
        $errors['psw'] = 'Пароль должен быть заполнен';
    }

    return $errors;
}

// =======================

$errors = validate($_POST);

if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');

    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"
    );

    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);
}

require_once './registration_form.php';

?>
$errorName = validateName(array $data);

if (!empty($errorName)) {
$errors['name'] = $errorName;
}



function validateName(array $data): null|string
{
if(isset($data['name'])){
$name = $data['name'];

if (strlen($name) < 2 ){
return 'Имя должно быть больше 2 символов';
}
return null;
} else {
return 'Имя должно быть заполнено';
}
}