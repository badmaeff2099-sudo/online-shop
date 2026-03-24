<?php
namespace Controller;
use Model\User;

class UserController
{

    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function getRegistrate(): void
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/registration_form.php';
    }

    public function registrate(): void
    {
        $errors = $this->validate($_POST);

        // внесение в БД, если нет ошибок
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-rep'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->insertUsers($name, $email, $password); // добавление пользователя

          //  $result = $this->userModel->getByEmail($email);// для вывода данных зарегистрированного пользователя на экран

           // print_r($result);
        }

        require_once '../Views/registration_form.php';


    }

    private function validate(array $data): array
    {
        $errors = [];

        // --- NAME ---
        $name = trim($data['name'] ?? '');
        if ($name === '') {
            $errors['name'] = "Имя должно быть заполнено";
        } elseif (mb_strlen($name) < 2) {
            $errors['name'] = "Имя должно быть больше 2 символов";
        }

        // --- EMAIL ---
        $email = trim($data['email'] ?? '');
        if ($email === '') {
            $errors['email'] = "Почта должна быть заполнена";
        } elseif (mb_strlen($email) < 2) {
            $errors['email'] = "Почта должна быть больше 2 символов";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email некорректный";
        } else {
            $user = $this->userModel->getByEmail($email);
            if ($user !== false) {
                $errors['email'] = "Этот Email уже зарегистрирован";
            }
        }

        // --- PASSWORD ---
        $password = $data['psw'] ?? '';
        $passwordRep = $data['psw-rep'] ?? '';

        if ($password === '') {
            $errors['psw'] = "Пароль должен быть заполнен";
        } elseif (mb_strlen($password) < 2) {
            $errors['psw'] = "Пароль должен быть больше 2 символов";
        } else {
            // проверяем повторный пароль только если основной пароль корректный
            if ($passwordRep === '') {
                $errors['psw-rep'] = "Повторный пароль должен быть заполнен";
            } elseif ($password !== $passwordRep) {
                $errors['psw-rep'] = "Пароли не совпадают";
            }
        }

        return $errors;
    }

    public function getProfile()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
        }
        require_once '../Views/profile_page.php';
    }

    public function profile()
    {
        session_start();

        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];

          //  require_once '../Model/User.php';
         //   $userModel = new User();

            $user = $this->userModel->getByUserId($userId);

            require_once '../Views/profile_page.php';
        } else {
            header("Location: /login");

        }
    }

    public function getLogin()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/login_form.php';
    }

    public function login()
    {
        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {

            $username = $_POST['username'];
            $password = $_POST['password'];


           // require_once '../Model/User.php';
          //  $userModel = new User();
            $user = $this->userModel->getByEmail($username);

            if (!empty($user)) {
                $passwordDb = $user['password'];

                if (password_verify($password, $passwordDb)) {

                    // успешный вход через сессии
                    session_start();
                    $_SESSION['userId'] = $user['id'];

                    header("Location: /catalog");

                } else {
                    $errors['username'] = 'username or password incorrect';
                }
            } else {
                $errors['username'] = 'Пользователя с таким логином не существует.';
            }
        }


        require_once '../Views/login_form.php';
    }

    private function validateLogin(array $data): array
    {
        $errors = [];

        $username = trim($data['username'] ?? '');
        $password = trim($data['password'] ?? '');

        if ($username === '') {
            $errors['username'] = "Введите Username";
        }

        if ($password === '') {
            $errors['password'] = "Введите Password";
        }

        return $errors;
    }

    public function getEditProfile()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            header("Location: /catalog");
        }
        require_once '../Views/edit_profile_form.php';
    }

    public function editProfile()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['userId'])) {

            header("Location: /login");
            exit;
        }


        $errors = $this->validateEditProfile($_POST);


        if (empty($errors)) {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $userId = $_SESSION['userId'];

          //  require_once '../Model/User.php';
         //   $userModel = new User();

            /*$pdo = new PDO ('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pwd');
            $stmt = $pdo->query("SELECT * FROM users WHERE id =" . $userId);
            $user = $stmt->fetch(); */

            $user = $this->userModel->getByUserId($userId); // getById

            if ($user['name'] !== $name) {
               $this->userModel->updateNameById($name, $userId);

            }

            if ($user['email'] !== $email) {
                $this->userModel->updateEmailById($email, $userId);
            }
            header("Location: /profile");
            exit;
        }


        require_once '../Views/edit_profile_form.php';
    }

    private function validateEditProfile(array $data): array
    {
        $errors = [];

        // объявление и валидация данных

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = "Имя должно быть больше 2 символов";
            }
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 2) {
                $errors['email'] = "Почта должна быть больше 2 символов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "email некорректный";
            } else {
                // соединение с БД

              //  require_once '../Model/User.php';
              //  $userModel = new User();
                $user = $this->userModel->getByEmail($email);

                $userId = $_SESSION['userId'];
                if ($user && $user['id'] !== $userId) {
                    $errors['email'] = "Этот Email уже зарегистрирован!";
                }
            }
        }


        return $errors;
    }
}